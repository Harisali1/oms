<?php

namespace App\Classes;

use App\Models\JoeyRoutificJob;
use App\Models\JoeyRoutificJobLocation;
use App\Models\JoeyRoutificJobRoute;
use App\Models\UserDevice;
use App\Models\UserNotification;

class Client {

    private $host = 'https://api.routific.com';
    private $host2 = 'https://routing-engine.afi.io';
    private $resource = '/';
    private $version = 'v1';
    private $endPoint = 'pdp-long';
    private $endPoint2 = 'jobs';




    public function getJobId($result) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host.$this->resource.$this->version.$this->resource.$this->endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $result,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJfaWQiOiI1MzEzZDZiYTNiMDBkMzA4MDA2ZTliOGEiLCJpYXQiOjEzOTM4MDkwODJ9.PR5qTHsqPogeIIe0NyH2oheaGR-SJXDsxPTcUQNq90E'
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if (empty($error)) {
            $response = explode("\n", $response);
            $results = $response[count($response) - 1];
            $results = json_decode($results);
        } else {
            $results = [];
        }

        return $results;
    }

    public function getJobIdByAfi($result) {

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => $this->host2.$this->resource.$this->endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $result,
            CURLOPT_HTTPHEADER => array(
                'access_token: jAoPrVrHBjNPWpZsbHdqvIGQsTgURLbKmBEhNpgr',
                'Content-Type: application/json'
            ),
        ));

        $response2 = curl_exec($curl2);
        $error2 = curl_error($curl2);
        curl_close($curl2);

        if (empty($error2)) {
            $results2 = $response2;
        } else {
            $results2 = [];
        }

        return $results2;
    }


    /**
     * @param $id
     * @param $response
     * @param $shiftId
     * @param $orderId
     * @return string
     */
    public function getJobResponseByJobId($id)
    {
        sleep(4);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host.$this->resource.$this->endPoint2.$this->resource.$id,
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

        $result = json_decode($response, true);

        $results = array_values($result['output']['solution']);

        if($result['output']['unserved'] == null){
            $jobCreation = ['job_id' => $id];

            $jobId = JoeyRoutificJob::create($jobCreation);

            foreach($results as $key => $res){
                $route = [
                    'joey_id' => $res[0]['location_id'],
                    'job_id' => $jobId->id,
                ];
                $routeJob = JoeyRoutificJobRoute::create($route);

                foreach($res as $index => $rrr){
                    if($index != 0){
                        $locations = [
                            'route_id' => $routeJob->id,
                            'sprint_id' => $rrr['location_id'],
                            'location_name' => $rrr['location_name'],
                            'type' => $rrr['type'],
                            'arrival_time' => $rrr['arrival_time'],
                            'finish_time' => $rrr['finish_time'],
                        ];

                        JoeyRoutificJobLocation::create($locations);
                    }
                }

                $deviceIds = UserDevice::where('user_id', $res[0]['location_id'])->pluck('device_token');

                $subject = 'Subject';
                $message = 'Your Route Notifications';

                Fcm::sendPush($subject, $message, 'suggestedRoute', null, $deviceIds);

                $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'suggestedRoute'],
                    'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'suggestedRoute']];
                $createNotification = [
                    'user_id' => $res[0]['location_id'],
                    'user_type' => 'Joey',
                    'notification' => $subject,
                    'notification_type' => 'suggestedRoute',
                    'notification_data' => json_encode(["body" => $message]),
                    'payload' => json_encode($payload),
                    'is_silent' => 0,
                    'is_read' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                UserNotification::create($createNotification);
            }
            return json_encode([
                "output"=>$results,
                "status" => 'Route Created Successfully'
            ]);
        }else{
            return json_encode([
                "status" => "Route Creation Error",
                "output"=>$result['output']['unserved']
            ]);
        }

    }


    public function getJobResponseByJobId2($id)
    {
        sleep(3);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host2.$this->resource.$this->endPoint2.$this->resource.$id,
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

        $result = json_decode($response, true);

//        dd($result);
        $results = array_values($result['output']['solution']);
        if($result['output']['unserved'] == null){
            $jobCreation = ['job_id' => $id];

            $jobId = JoeyRoutificJob::create($jobCreation);

            foreach($results as $key => $res){
                $joey = explode('_', $res[0]['location_id']);
                $route = [
                    'joey_id' => $joey[1],
                    'job_id' => $jobId->id,
                ];

                $start_date = date('Y-m-d').' 00:00:00';
                $end_date = date('Y-m-d').' 23:59:00';
                $joeyRoute = JoeyRoutificJobRoute::where('joey_id', $joey[1])->whereBetween('created_at',array($start_date,$end_date))->exists();

                if($joeyRoute == true) {
                    return json_encode([
                        "status" => "Success",
                        "output" => 'This joey has been already in route'
                    ]);
                }

                if($joeyRoute == false){
                    $routeJob = JoeyRoutificJobRoute::create($route);

                    foreach($res as $index => $rrr){
                        if($index != 0){

                            $sprintId = explode('_', $rrr['location_id']);
                            $address = '';

                            if($rrr['type'] == 'pickup'){
                                $address = $result['network']['v_'.$sprintId[1].'_pickup']['address'];
                            }
                            if($rrr['type'] == 'dropoff'){
                                $address = $result['network']['v_'.$sprintId[1].'_dropoff']['address'];
                            }

                            $locations = [
                                'route_id' => $routeJob->id,
                                'sprint_id' => $sprintId[1],
                                'location_name' => $address,
                                'type' => $rrr['type'],
                                'arrival_time' => $rrr['arrival_time'],
                                'finish_time' => $rrr['finish_time'],
                            ];

                            JoeyRoutificJobLocation::create($locations);
                        }
                    }

                    $deviceIds = UserDevice::where('user_id', $res[0]['location_id'])->pluck('device_token');

                    $subject = 'Subject';
                    $message = 'Your Route Notifications';

                    Fcm::sendPush($subject, $message, 'suggestedRoute', null, $deviceIds);

                    $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'suggestedRoute'],
                        'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'suggestedRoute']];
                    $createNotification = [
                        'user_id' => $res[0]['location_id'],
                        'user_type' => 'Joey',
                        'notification' => $subject,
                        'notification_type' => 'suggestedRoute',
                        'notification_data' => json_encode(["body" => $message]),
                        'payload' => json_encode($payload),
                        'is_silent' => 0,
                        'is_read' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    UserNotification::create($createNotification);
                }

            }
            return json_encode([
                "output"=> $results,
                "status" => 'Route Created Successfully'
            ]);
        }else{
            return json_encode([
                "status" => "Route Creation Error",
                "output"=>$result['output']['unserved']
            ]);
        }
    }

}
