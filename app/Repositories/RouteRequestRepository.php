<?php

namespace App\Repositories;

use App\Models\Interfaces\SprintZoneScheduleInterface;
use App\Models\Interfaces\ZoneScheduleInterface;
use App\Models\Interfaces\ZonesInterface;
use App\Models\JoeyLocation;
use App\Models\JoeysZoneSchedule;
use App\Models\Location;
use App\Models\SprintTask;
use App\Models\SprintZoneSchedule;
use App\Repositories\Interfaces\RouteRequestRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class AdminRepository
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
 */
class RouteRequestRepository implements RouteRequestRepositoryInterface
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

    public function shiftOrders($id)
    {
        return SprintZoneSchedule::whereNull('deleted_at')
            ->where('zone_schedule_id', '=', $id)
            ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
            ->pluck('sprint_id');
    }

    public function sprintTask($id)
    {
        return  SprintTask::whereNull('deleted_at')
            ->where('sprint_id', '=', $id)
            ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
            ->get(['id', 'location_id', 'type', 'eta_time', 'etc_time']);
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
        return JoeysZoneSchedule::whereNull('deleted_at')
            ->where('zone_schedule_id', '=', $id)
            ->where('start_time', '>=', date('Y-m-d').' 00:00:00')
            ->pluck('joey_id');
    }

    public function joeyLocation($id)
    {
        return DB::table('joey_locations')
            ->where('joey_id', '=', $id)
            ->orderBy('updated_at', 'DESC')
            ->first(['latitude', 'longitude', 'id']);
    }

}
