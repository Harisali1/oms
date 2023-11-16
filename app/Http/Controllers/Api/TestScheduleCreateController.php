<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JoeysZoneSchedule;
use App\Models\ZoneSchedule;

class TestScheduleCreateController extends Controller
{


    public function index()
    {
        foreach(range(1,3000) as $key => $item){
            if($key % 30 == 0){
                $start = mktime($key, $key, $key, 12, 20, 2021);
                $startDate = date("Y-m-d H:i:s", $start);
                $end = mktime($key+2, $key, $key, 12, 20, 2021);
                $endDate = date("Y-m-d H:i:s", $end);

                if($startDate >= date('Y-m-d')){
                    break;
                }
            }
            $data = [
                'zone_id' => 24,
                'start_time' => $startDate,
                'end_time' => $endDate,
                'occupancy' => 1,
                'capacity' => 1,
                'is_display' => 0
            ];
            $schedule = ZoneSchedule::create($data);

            JoeysZoneSchedule::create([
                'joey_id' => 1,
                'zone_schedule_id' =>$schedule->id,
                'start_time' => $startDate,
                'end_time' => $endDate
            ]);
        }


        return json_encode([
            "status" => "Shifts Created Successfully",
        ]);

    }

}
