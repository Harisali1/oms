<?php

namespace App\Http\Controllers\Front;

use App\Classes\Fcm;
use App\Http\Controllers\Controller;
use App\Models\Joey;
use App\Models\JoeysZoneSchedule;
use App\Models\UserDevice;
use App\Models\UserNotification;
use App\Models\Zones;
use App\Models\ZoneSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftPublisherController extends Controller
{
    public function index()
    {
        $allZones = Zones::all();
        $shifts = ZoneSchedule::all();
        $zoneSchedules = ZoneSchedule::with('zone', 'vehicle','joeySchedule')
            ->whereDate('start_time', '=', Carbon::now())
            ->where('is_display', '=', 1)
            ->get();

        return view('front.schedule.publisher.index', compact('zoneSchedules', 'allZones', 'shifts'));
    }

    public function search(Request $request)
    {

        $allZones = Zones::all();
        $shifts = ZoneSchedule::all();
        $zoneId = $request->get('zone_id');
        $shiftId = $request->get('shift_id');

        $zoneSchedules =  ZoneSchedule::with('zone','vehicle','joeySchedule');

        if($request->get('daterange') != null){
            if(!empty($request->get('daterange'))){
                $dates = explode(' - ', ($request->get('daterange')));
                $startDate = date("Y-m-d", strtotime($dates[0]));
                $endDate = date("Y-m-d", strtotime($dates[1]));
                $zoneSchedules = $zoneSchedules->whereBetween('start_time',array($startDate,$endDate));
            }
        }

        if(!empty($request->get('shift_id'))){
            $zoneSchedules = $zoneSchedules->where('id', '=', $request->get('shift_id'));
        }

        if(!empty($request->get('zone_id'))){
            $zoneSchedules = $zoneSchedules->where('zone_id', '=', $request->get('zone_id'));
        }

        if($request->get('is_display') == 1){
            $zoneSchedules = $zoneSchedules->where('is_display', '=', 1);
        }

        if($request->get('is_display') == 0){
            $zoneSchedules = $zoneSchedules->where('is_display', '=', 0);
        }


        $zoneSchedules = $zoneSchedules->get();
        return view('front.schedule.publisher.index', compact('zoneSchedules', 'allZones', 'shifts', 'zoneId', 'startDate', 'endDate', 'shiftId'));
    }

    public function status(ZoneSchedule $schedule, Joey $joey)
    {
        $deviceIds = UserDevice::where('user_id', $joey->id)->pluck('device_token');

        $subject = 'Subject';
        $message = 'Available Shifts';

        Fcm::sendPush($subject, $message, 'availableShifts', null, $deviceIds);

        $payload = ['notification' => ['title' => $subject, 'body' => $message, 'click_action' => 'availableShifts'],
            'data' => ['data_title' => $subject, 'data_body' => $message, 'data_click_action' => 'availableShifts']];
        $createNotification = [
            'user_id' => $joey->id,
            'user_type' => 'Joey',
            'notification' => $subject,
            'notification_type' => 'availableShifts',
            'notification_data' => json_encode(["body" => $message]),
            'payload' => json_encode($payload),
            'is_silent' => 0,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        UserNotification::create($createNotification);

        $schedule->update([
            'is_display' => !$schedule->is_display
        ]);
        return redirect()
            ->route('shift.publisher.index')
            ->with('success', 'Schedule changed status successfully.');
    }

    public function enabledDisabledSchedule(Request $request)
    {
        if($request->get('type') == 'enabled'){
            $ids = $request->ids;
            ZoneSchedule::whereIn('id',explode(",",$ids))->update(['is_display' => 1]);
            return response()->json(['success'=>"Enabled Schedule Successfully."]);
        }
        if($request->get('type') == 'disabled'){
            $ids = $request->ids;
            ZoneSchedule::whereIn('id',explode(",",$ids))->update(['is_display' => 0]);
            return response()->json(['success'=>"Disabled Schedule Successfully."]);
        }
    }
}
