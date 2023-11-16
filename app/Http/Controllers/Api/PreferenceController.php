<?php

namespace App\Http\Controllers\Api;

use App\Classes\Client;
use App\Classes\Fcm;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Repositories\Interfaces\PreferenceRepositoryInterface;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    private $preferenceRepository, $dropoff_date_time;


    /**
     * Create a new controller instance.
     *
     * @param PreferenceRepositoryInterface $preferenceRepository
     * @param Client $client
     */
    public function __construct(PreferenceRepositoryInterface $preferenceRepository)
    {
        parent::__construct();
        $this->preferenceRepository = $preferenceRepository;
    }

    //========== main function start ==========//
    public function order_type(Request $request){
        if($this->preferenceRepository->unaccepted_orders_ondemand()->isEmpty()){
            return "no order";
        }
        $unaccepted_orders_ondemand = $this->preferenceRepository->unaccepted_orders_ondemand();
        $unaccepted_orders_express = $this->preferenceRepository->unaccepted_orders_express();
        // Fetching orders which are not accepted on demand
        if(empty($unaccepted_orders_ondemand)){
            return 'No on demand orders found today';
        }
        else{
            // passing all orders of on demand type in orders function
            $final_request = $this->orders($unaccepted_orders_ondemand);
            // hitting curl request
        }

        if(gettype($final_request) == 'string'){
            return $final_request;
        }
        else{
            return $this->get_job_id_curl($final_request);
        }
    }
    //========== main function end ==========//

    //========== orders loop function=========//
    private function orders($orders_all){
        foreach ($orders_all as $orders){
            //check order type for applying algo
            // shift available flag to check if shift is created or not
            $shift_available_flag = 0;
            // getting dropoff date time
            $this->dropoff_date_time = strtotime($orders->time);
            // getting zone id from spirint so can get shifts
            $zone_id = $this->preferenceRepository->get_zone_id($orders->sprint_id);
            // getting zone schedules from zone_id
            $zone_schedules = $this->preferenceRepository->get_zone_schedules($zone_id);
            // checking if shift is created for next two hours
            $flag = 0;
            // looping through shifts to broad cast orders to joeys
            foreach($zone_schedules as $schedule){
                $shift_available_flag = 1;
                // checking time lies in between the shift time
                if($this->dropoff_date_time >= strtotime($schedule->start_time) && $this->dropoff_date_time <= strtotime($schedule->end_time)){
                    // checking joeys are available
                    $joeys_available_count =  $schedule->occupancy ;
                    // if joeys are available
                    if($joeys_available_count > 0){
                        // function called for shifts
                        $final_request = $this->shifts_available($schedule,$this->dropoff_date_time);
                    }
                    // if no joeys are available in the shift
                    else{
                        // notify joeys who will be starting shift in 2 hours from order time , to join early
                        $dropoff_date_time = $this->dropoff_date_time + 7200; // adding two hours to time
                        $zone_schedules_prior = $this->preferenceRepository->get_zone_schedules_prior($zone_id,$dropoff_date_time);
                        // if shift is found in next 2 hours
                        if(isset($zone_schedules_prior->id)){
                            // function called for checking shifts available in next two hours
                            $final_request = $this->shifts_available_prior($zone_schedules_prior,$zone_id,($dropoff_date_time - 7200 ));
                        }
                    }
                }
                else{
                    // block for if time condition is not met then what to do
                    return $final_request =  "No shift found within the time or prior to this zone";
                }
            }
            // if no shifts found then create shift and will apply the same conditions to notify joeys
            if(!$shift_available_flag){
               // Creating shift and then broadcast it
               $created_shift_details = $this->preferenceRepository->create_shift($zone_id,$this->dropoff_date_time);
               // function to notify joeys who have set their preferred zone as created zone id
               $preferred_zone_joeys = $this->preferenceRepository->preffered_zone_joeys($created_shift_details->zone_id);
               $final_request = $this->new_shifts($created_shift_details,$preferred_zone_joeys);
            }
        }
        return $final_request;
    }

    //========== function to get joeys who have open shifts or have shifts created ==========//
    private function shifts_available($schedule,$dropoff_date_time){
        $request_data = array();
        // getting joeys zone schedule id to get joeys who have accepted shifts
        $joeys_in_shift = $this->preferenceRepository->occupiedJoey($schedule->id);

        arsort($joeys_in_shift);
        // looping joeys in shift
        foreach ($joeys_in_shift as $joey => $value){
            // checking joeys who have started shift
            if($value && $this->dropoff_date_time >= strtotime($schedule->start_time)){
                // getting orders from joeys for checking routing
                $sprints = $this->preferenceRepository->joey_orders($joey);
                //pushing current on demand order to sprints
                array_push($request_data,$this->request_body_available($sprints,$joey));
            }
            // joeys who have not started shift
            else{
                // getting orders from joeys for checking routing
                $sprints = $this->preferenceRepository->joey_orders($joey);
                //pushing current on demand order to sprints
                array_push($request_data,$this->request_body_available($sprints,$joey));
            }
        }
        return $request_data;
    }

    //============ function to check shift for next two hours of time ===========//
    private function shifts_available_prior($zone_schedules_prior,$zone_id,$dropoff_date_time){
        $count = 0;
        foreach ($zone_schedules_prior as $prior_zone_schedule ){
            // checking if joeys are available
            $joeys_available_count =  $prior_zone_schedule->occupancy ;
   
            if($joeys_available_count > 0){
                // if shift found call shifts available fucntion
                return $this->shifts_available($prior_zone_schedule,$dropoff_date_time);
            }
            // search all joeys of zone for the day
            else{
                $remaing_shifts = $this->preferenceRepository->get_all_shifts($zone_id,$dropoff_date_time);
                $request_data = array();
                foreach ($remaing_shifts as $joeys){
                    // getting orders from joeys for checking routing
                    $sprints = $this->preferenceRepository->joey_orders($joeys->joey_id);
                    //$joey_current_location = $this->preferenceRepository->joey_location($joeys->joey_id);
                    //pushing current on demand order to sprints
                    array_push($request_data,$this->request_body_prior($sprints,$joeys));
                }
            }
        }
        return $request_data;
    }

    //========== function to get joeys for which new shifts is created ==========//
    private function new_shifts($created_shift_details,$preferred_zone_joeys){
        $request_data = array();
        // getting joeys zone schedule id to get joeys who have accepted shifts
        $joeyIds = $preferred_zone_joeys->pluck('id');
        $joeys_in_shift = $this->preferenceRepository->addingJoeyZoneSchedule($created_shift_details->id,$joeyIds,$created_shift_details->start_time,$created_shift_details->end_time);
        arsort($joeys_in_shift);
        // looping joeys in new shift
        foreach (array_slice($joeys_in_shift, 1) as $joey){
            foreach ($joey as $id){
                $sprints = $this->preferenceRepository->joey_orders($id);
                //pushing current on demand order to sprints
                array_push($request_data,$this->request_body_available($sprints,$id));
            }
        }
        return $request_data;
    }

    //============ function to prepare data for curl shifts prior ===============//
    private function request_body_prior($sprints,$joeys){
        // request array
        $ondemand_orders = $this->preferenceRepository->ondemand_orders_array();
        foreach ($ondemand_orders as $order){
            array_push($sprints,$order);
        }
        $joey_detail_array = [];
        $request_data = array("fleet"=>$joey_detail_array,"visits"=>array());
        $joey_detail = $this->preferenceRepository->get_joey_detail($joeys->joey_id);
        // preparing joey details to push
        $joey_detail_array = array(
            $joey_detail->first_name.'_'.$joey_detail->last_name =>array(
                "id" => $joeys->joey_id,
                "start_location"=>
                    array(
                        "id" => $joey_detail->first_name.'_'.$joey_detail->last_name,
                        "address" => $joey_detail->address,
                        "lat" => (float)substr($joey_detail->latitude, 0, 8) / 1000000,
                        "lng" => (float)substr($joey_detail->longitude, 0, 9) / 1000000,
                    ),
                "type" => array($joey_detail->first_name.'_'.$joey_detail->last_name),
                "capacity" => 2
            )
        );
        // pushing joey details in request array
        $request_data["fleet"] = $joey_detail_array;

        // looping through sprints for visits
        foreach ($sprints as $sprint) {
            // getting spring tasks
            $tasks = $this->preferenceRepository->sprintTask($sprint);
            // looping through sprint tasks
            foreach ($tasks as $task_details) {
                // get details from locaion id in sprint task table
                $location_details = $this->preferenceRepository->get_location_details($task_details->location_id);
                // creating an array in order to push into request array
                $location = array("location"=>
                    ['name'=>(isset($location_details->address)) ? $location_details->address : 'name',
                        'address'=>(isset($location_details->address)) ? $location_details->address : 'address',
                        'lat' => (isset($location_details->latitude)) ? (float)substr($location_details->latitude, 0, 8) / 1000000 : 'lat',
                        'lng'=>(isset($location_details->longitude)) ? (float)substr($location_details->longitude, 0, 9) / 1000000 : 'lng']
                );
                // assigning key value to task type (dropoff/pickup)
                $request_data["visits"][$sprint][$task_details->type] = $task_details->type;
                // start end time of dropoff
                $dropoff_start_end = $this->preferenceRepository->get_start_end_time($task_details->id);
                if($request_data["visits"][$sprint][$task_details->type] == "dropoff"){
                    $request_data["visits"][$sprint]["dropoff"] = $location;
                    $request_data["visits"][$sprint]["dropoff"]["start"] = isset($dropoff_start_end->start_time) ? $dropoff_start_end->start_time : NULL;
                    $request_data["visits"][$sprint]["dropoff"]["end"] = isset($dropoff_start_end->end_time) ? $dropoff_start_end->end_time : NULL;
                }
                if($request_data["visits"][$sprint][$task_details->type]=="pickup"){
                    $request_data["visits"][$sprint]["pickup"] = $location;
                    $request_data["visits"][$sprint]["pickup"]["start"] = gmdate('h:i',$task_details->due_time);
                    $request_data["visits"][$sprint]["pickup"]["end"] = gmdate('h:i',$task_details->eta_time);
                }
            }
            $request_data["visits"][$sprint]["load"] = 1;
            $request_data["visits"][$sprint]["type"] = [
                $joey_detail->first_name.'_'.$joey_detail->last_name
            ];
        }
        return $request_data;
    }

    //============ function to prepare data for curl shifts available ===============//
    private function request_body_available($sprints,$joeys){
        // request array
        $ondemand_orders = $this->preferenceRepository->ondemand_orders_array();
        foreach ($ondemand_orders as $order){
            array_push($sprints,$order);
        }
        $joey_detail_array = [];
        $request_data = array("fleet"=>$joey_detail_array,"visits"=>array());
        $joey_detail = $this->preferenceRepository->get_joey_detail($joeys);
        dd($joey_detail);
        // preparing joey details to push
        $joey_detail_array = array(
            $joey_detail->first_name.'_'.$joey_detail->last_name =>array(
                "id" => $joeys,
                "start_location"=>
                    array(
                        "id" => $joey_detail->first_name.'_'.$joey_detail->last_name,
                        "address" => $joey_detail->address,
                        "lat" => (float)substr($joey_detail->latitude, 0, 8) / 1000000,
                        "lng" => (float)substr($joey_detail->longitude, 0, 9) / 1000000,
                    ),
                "type" => array($joey_detail->first_name.'_'.$joey_detail->last_name),
                "capacity" => 2
            )
        );
        // pushing joey details in request array
        $request_data["fleet"] = $joey_detail_array;

        // looping through sprints for visits
        foreach ($sprints as $sprint) {
            // getting spring tasks
            $tasks = $this->preferenceRepository->sprintTask($sprint);
            // looping through sprint tasks
            foreach ($tasks as $task_details) {
                // get details from locaion id in sprint task table
                $location_details = $this->preferenceRepository->get_location_details($task_details->location_id);
                // creating an array in order to push into request array
                $location = array("location"=>
                    ['name'=>(isset($location_details->address)) ? $location_details->address : 'name',
                        'address'=>(isset($location_details->address)) ? $location_details->address : 'address',
                        'lat' => (isset($location_details->latitude)) ? (float)substr($location_details->latitude, 0, 8) / 1000000 : 'lat',
                        'lng'=>(isset($location_details->longitude)) ? (float)substr($location_details->longitude, 0, 9) / 1000000 : 'lng']
                );
                // assigning key value to task type (dropoff/pickup)
                $request_data["visits"][$sprint][$task_details->type] = $task_details->type;
                // start end time of dropoff
                $dropoff_start_end = $this->preferenceRepository->get_start_end_time($task_details->id);
                if($request_data["visits"][$sprint][$task_details->type] == "dropoff"){
                    $request_data["visits"][$sprint]["dropoff"] = $location;
                    $request_data["visits"][$sprint]["dropoff"]["start"] = isset($dropoff_start_end->start_time) ? $dropoff_start_end->start_time : NULL;
                    $request_data["visits"][$sprint]["dropoff"]["end"] = isset($dropoff_start_end->end_time) ? $dropoff_start_end->end_time : NULL;
                }
                if($request_data["visits"][$sprint][$task_details->type]=="pickup"){
                    $request_data["visits"][$sprint]["pickup"] = $location;
                    $request_data["visits"][$sprint]["pickup"]["start"] = gmdate('h:i',$task_details->due_time);
                    $request_data["visits"][$sprint]["pickup"]["end"] = gmdate('h:i',$task_details->eta_time);
                }
            }
            $request_data["visits"][$sprint]["load"] = 1;
            $request_data["visits"][$sprint]["type"] = [
                $joey_detail->first_name.'_'.$joey_detail->last_name
            ];
        }
        return $request_data;
    }

    //============ function to hit curl afi =================//
    private function get_job_id_curl($request){
         // initialising curl for generating job id
        $data_string = json_encode( $request );
        $final_response = array();

        // looping through request data in order to hit AFI api
        foreach (json_decode($data_string) as $joey){
            $data_string = json_encode( $joey );
            // curl to get the job id of the joeys
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://routing-engine.afi.io/pdp-long',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data_string,
                CURLOPT_HTTPHEADER => array(
                    'access_token: jAoPrVrHBjNPWpZsbHdqvIGQsTgURLbKmBEhNpgr',
                    'google_key: AIzaSyBrGqkCJjuUFNQ7c1JebPlkxXmR-5UacJM',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response,true);

            $job_id =  $response['job_id'];

            // setting up curl to get orders served and unserved
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://routing-engine.afi.io/jobs/'.$job_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response,true);

            //checking if any order is unserved or not
            $check_unserved = $response['output']['unserved'];

            $joey_detail = $response['input']['fleet'];
            // getting input array
            $inputs = $response['input']['visits'];
            // getting all served orders
            $solution = $response['output']['solution'];

            // if there is any unserved order
            if($check_unserved){

                $this->exclusive_orders($joey_detail,$inputs,$solution,$check_unserved);

            }
            else{

                $this->exclusive_orders($joey_detail,$inputs,$solution,$check_unserved);

            }
            $final_response[] = $response;
        }
        return $final_response;
    }

    //============= function ito insert into exclusive orders and check ===============//
    private function exclusive_orders($joey_detail,$inputs,$solution,$check_unserved){

        $output_finsh_time = [];
        $input_end_time = [];
        // if orders are in unserved
        if($check_unserved){
            // getting unserved sprint orders byu joeys and picking up sprint ids
            foreach ($check_unserved as $sprint_id => $value){
                $unserved_sprint = $sprint_id;
                // removing unserved sprints from input because it will cause error in merging and its not required too
                unset($inputs[$unserved_sprint]);
            }
        }

        // getting joey id
        foreach ($joey_detail as $value){
            $joey_id = $value['id'];
        }

        // looping through input array to push end times of sprint
        foreach ($inputs as $sprint => $sprint_detail){
            $input_end_time[$sprint][] = $sprint_detail["dropoff"]['end'];
        }


        // looping through joey for solution
        foreach ($solution as $joey){
            // looping through joey orders
            for($i=0; $i<count($joey); $i++){
                if($i>0){
                    // getting only dropoff array for finish time
                    if($joey[$i]['type'] == 'dropoff'){
                        $output_finsh_time[$joey[$i]['location_id']][] = $joey[$i]['finish_time'];
                    }
                }
            }
        }

        //merging input and outputs of same sprint in single array
        foreach($input_end_time as $key=>$array) {
            $merged_array[$key] = array_merge($array, $output_finsh_time[$key]);
        }

        // looping to caluculate if order is being delayed or not
        foreach($merged_array as $sprint_id => $sprint){
            $time_diff = date("H:i",strtotime($sprint[0]) - strtotime($sprint[1]));
            $exclusive_order_inserted = $this->preferenceRepository->exclusive_orders($sprint_id,$joey_id);
            // sending notification to joey
            //$this->send_notification($sprint_id,$joey_id);
        }
    }

    //=========== function to send notification =============//
    private function send_notification($sprint_id,$joey_id){
            if (isset($joey_id)) {
                $deviceIds = $this->preferenceRepository->user_device($joey_id);
                $subject = 'Notification for orders';
                $message = 'Your have a new order CR-'.$sprint_id;
                Fcm::sendPush($subject, $message, 'ecommerce', null, $deviceIds);
                $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'ecommerce'],
                    'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'ecommerce']];
                $createNotification = [
                    'user_id' => $joey_id,
                    'user_type' => 'Joey',
                    'notification' => $subject,
                    'notification_type' => 'ecommerce',
                    'notification_data' => json_encode(["body" => $message]),
                    'payload' => json_encode($payload),
                    'is_silent' => 0,
                    'is_read' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->preferenceRepository->user_notification($createNotification);
            }
        //echo  "Notification Send";
    }
}
