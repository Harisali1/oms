<?php

namespace App\Repositories;

use App\Models\ExclusiveOrderJoey;
use App\Models\Interfaces\SprintZoneScheduleInterface;
use App\Models\Interfaces\ZoneScheduleInterface;
use App\Models\Interfaces\ZonesInterface;
use App\Models\Joey;
use App\Models\JoeyLocation;
use App\Models\JoeysZoneSchedule;
use App\Models\Location;
use App\Models\MerchantIds;
use App\Models\MerchantsIds;
use App\Models\Sprint;
use App\Models\SprintTask;
use App\Models\SprintZone;
use App\Models\SprintZoneSchedule;
use App\Models\SprintOrderPreference;
use App\Models\UserDevice;
use App\Models\UserNotification;
use App\Models\ZoneSchedule;
use App\Repositories\Interfaces\PreferenceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class AdminRepository
 *
 * @author Muhammad Zahid
 * email : zahidnasim@live.com
 */
class PreferenceRepository implements PreferenceRepositoryInterface
{
    private $zones;

    public function __construct(ZonesInterface $zones)
    {
        $this->zones = $zones;
    }


    public function all()
    {
        return $this->zones::all();
    }

    public function create(array $data)
    {
        $model = $this->zones::create($data);
        return $model;
    }

    public function find($id)
    {
        return $this->zones::where('id', $id)->first();
    }

    public function update($id, array $data)
    {
        $this->zones::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->zones::where('id', $id)->delete();
    }

    public function zones()
    {
        return $this->zones::whereNull('deleted_at')->pluck('id');
    }

    public function shifts($id)
    {
        $start_date = date('Y-m-d').' 00:00:00';
        $end_date = date('Y-m-d').' 23:59:00';
        $start_date = ConvertTimeZone($start_date,'America/Toronto', 'UTC');
        $end_date = ConvertTimeZone($end_date,'America/Toronto', 'UTC');

        $schedule =  DB::table('zone_schedule')->where('zone_id', '=', $id)
            ->whereBetween('start_time',array($start_date,$end_date))
            ->get(['id', 'zone_id', 'start_time', 'end_time', 'capacity']);

        $schedule = $schedule->whereNull('deleted_at');

        return $schedule;
    }

    public function shiftOrders($id){
        return SprintZoneSchedule::whereNull('deleted_at')
            ->where('zone_schedule_id', '=', $id)
            ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
            ->pluck('sprint_id');
    }

    public function sprintTask($id)
    {
        return  SprintTask::whereNull('deleted_at')
            ->where('sprint_id', '=', $id)
            //->where('created_at', '>=', date('Y-m-d').' 00:00:00')
            ->get(['id', 'location_id', 'type','due_time', 'eta_time', 'etc_time']);
    }

    public function merchant($id)
    {
        return DB::table('merchantids')->whereNull('deleted_at')
            ->where('task_id', '=', $id)
            ->first(['start_time', 'end_time']);
    }

    public function location($id)
    {
        Location::find($id);
    }

    public function occupiedJoey($id)
    {
        return  JoeysZoneSchedule::whereNull('deleted_at')
            ->where('zone_schedule_id', '=', $id)
            ->whereNull('end_time')
            ->pluck('start_time','joey_id')->toArray();
    }

    public function addingJoeyZoneSchedule($id,$joeyIds,$shift_start_time,$shift_end_time){
        $arr_joey_zone_schedule = array('start_time' => array(),'joey_id' => array());
        foreach ($joeyIds as $joeyId){
            $joey_zone_schedule =  JoeysZoneSchedule::create([
                'joey_id' => $joeyId,
                'zone_schedule_id' => $id,
                'start_time' => $shift_start_time,
                'deleted_at' => NULL
            ]);
            array_push($arr_joey_zone_schedule['start_time'],$joey_zone_schedule->start_time);
            array_push($arr_joey_zone_schedule['joey_id'],$joey_zone_schedule->joey_id);
        }
        return $arr_joey_zone_schedule;
    }

    public function joeyLocation($id)
    {
        return DB::table('joey_locations')
            ->where('joey_id', '=', $id)
            ->orderBy('updated_at', 'DESC')
            ->first(['latitude', 'longitude', 'id']);
    }

    public function unaccepted_orders_ondemand(){
        //return SprintOrderPreference::where('sprint_id','=',$sprint_id)->get();
        return SprintOrderPreference::whereDate('created_at', Carbon::today())
            ->where('is_accepted','=',0)
            ->where('type','=','on_demand')
            ->whereNull('deleted_at')
            ->get();

    }

    public function unaccepted_orders_express(){
        //return SprintOrderPreference::where('sprint_id','=',$sprint_id)->get();
        return SprintOrderPreference::whereDate('created_at', Carbon::today())
            ->where('is_accepted','=',0)
            ->where('type','=','express')
            ->get();

    }

    public function ondemand_orders_array(){
        //return SprintOrderPreference::where('sprint_id','=',$sprint_id)->get();
        return SprintOrderPreference::whereDate('created_at', Carbon::today())
            ->where('is_accepted','=',0)
            ->whereNull('deleted_at')
            ->pluck('sprint_id')->toArray();
    }

    public function get_zone_id($sprint_id){
        return SprintZone::where('sprint_id','=',$sprint_id)->pluck('zone_id')->toArray();
    }

    public function get_zone_schedules($zone_ids){
        return ZoneSchedule::whereIn('zone_id',$zone_ids)
        ->where('start_time','>=',Carbon::today())
        ->whereNull('deleted_at')
        ->get();
    }

    public function get_zone_schedules_prior($zone_ids,$date_time){
        return ZoneSchedule::whereIn('zone_id',$zone_ids)
            ->where('start_time', '<=', date('Y-m-d H:i:s',$date_time))
            ->where('end_time', '>=', date('Y-m-d H:i:s',$date_time))
            ->get();
    }

    public function create_shift($zone_id,$dropoff_date_time){
        $zone_id = $zone_id[0];
        $start_time = date('Y-m-d H:i:s');
        // Adding two hours to end the shift
        //echo strftime("%Y-%m-%d %H:%M:%S",$dropoff_date_time);
        $end_time = strftime("%Y-%m-%d %H:%M:%S", $dropoff_date_time+ 3*60*60);
        //echo strftime($end_time);
        return ZoneSchedule::create([
            'zone_id' => $zone_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'occupancy' => 1,
            'capacity' => 4,
            'deleted_at' => NULL
        ]);
    }

    public function preffered_zone_joeys($zone_id){
        return Joey::where('preferred_zone','=',$zone_id)->get();
    }

    public function get_all_shifts($zone_id,$dropoff_date_time){
        $all_shifts = ZoneSchedule::where('zone_id','=',$zone_id)
        ->where('start_time','>=',date('Y-m-d H:i:s',$dropoff_date_time))
        ->where('occupancy','>',0)
        ->pluck('id')->toArray();

        $all_shifts_schedule = JoeysZoneSchedule::whereIn('zone_schedule_id',$all_shifts)->get();
        return $all_shifts_schedule;
    }

    public function get_shifts($zone_id,$dropoff_date_time){
        $all_shifts = ZoneSchedule::where('zone_id','=',$zone_id)
        ->where('start_time','>=',date('Y-m-d H:i:s',$dropoff_date_time))
        ->where('occupancy','>',0)
        ->pluck('id')->toArray();

        $all_shifts_schedule = JoeysZoneSchedule::whereIn('zone_schedule_id',$all_shifts)->get();
        return $all_shifts_schedule;
    }

    public function joey_orders($joey_id){
        $orders = Sprint::where('joey_id','=',$joey_id)->whereIn('status_id',[config('status.active')])->pluck('id')->toArray();
        return $orders;
    }

    public function joey_location($joey_id){
        $location_id = Joey::where('id','=',$joey_id)->first();
        $location = Location::where('id','=',$location_id->current_location_id)->get();
        return $location;
    }

    public function get_location_details($location_id){
        return Location::where('id','=',$location_id)->first();
    }

    public function get_start_end_time($task_id){
        return MerchantIds::where('task_id','=',$task_id)->first();
    }

    public function get_joey_detail($id){
        return DB::table('joeys')
            ->join('joey_locations', 'joeys.id', '=', 'joey_locations.joey_id')
            ->select('joeys.first_name', 'joeys.last_name', 'joeys.address',
                    'joey_locations.latitude','joey_locations.longitude')
            ->where('joeys.id','=',$id)
            ->orderByDesc('joey_locations.id')
            ->first();;
    }

    public function exclusive_orders($sprint_id,$joey_id){
        if(isset($sprint_id) && isset($joey_id)){
            ExclusiveOrderJoey::create([
                'order_id' => $sprint_id,
                'joey_id' => $joey_id
            ]);
            $response = json_encode(array("message"=>"Order no".$sprint_id." notified to joey".$joey_id,"code"=>200));
            return $response;
        }
        else{
            $response = json_encode(array("message"=>"Order id or Joeyid is missing","code"=>400));
            return $response;
        }
    }

    public function user_device($joey_id){
        return UserDevice::where('user_id', $joey_id)->pluck('device_token');
    }

    public function user_notification($createNotification){
        return UserNotification::create($createNotification);

    }
}
