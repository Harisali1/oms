<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ScheduleStoreRequest;
use App\Models\Joey;
use App\Models\JoeysZoneSchedule;
use App\Models\Zones;
use App\Models\ZoneSchedule;
use App\Repositories\Interfaces\JoeyZoneScheduleRepositoryInterface;
use App\Repositories\Interfaces\ZoneScheduleRepositoryInterface;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    private $zoneScheduleRepository;
    private $joeyZoneScheduleRepository;

    public function __construct(ZoneScheduleRepositoryInterface $zoneScheduleRepository, JoeyZoneScheduleRepositoryInterface $joeyZoneScheduleRepository)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->zoneScheduleRepository = $zoneScheduleRepository;
        $this->joeyZoneScheduleRepository = $joeyZoneScheduleRepository;
    }

    public function index()
    {
        $allZones = Zones::all();
        $date = date('Y-m-d h:i:s');

//        $joeyZoneSchedules = JoeysZoneSchedule::with('schedule', 'joey')->whereHas('schedule', function ($query) {
//            $query->whereDate('start_time', '=', Carbon::now());
//        })->orderBy('id', 'DESC')->paginate(10);

        $zoneSchedules = ZoneSchedule::with('zone', 'joeySchedule')
            ->whereDate('start_time', '=', Carbon::now())
            ->get();

        $data = [];
        foreach($zoneSchedules as $zoneSchedule)
        {   $data[$zoneSchedule->zone_id]['name'] = $zoneSchedule->zone->name;
            $data[$zoneSchedule->zone_id]['data'][] = $zoneSchedule;

        }

        return view('front.schedule.index', compact('data', 'allZones', 'date'));
    }

    public function create()
    {
        $joeys = Joey::where('on_duty', '=', 1)->whereNull('deleted_at')->get();
        $zones = Zones::all();

        return view('front.schedule.create', compact('joeys', 'zones'));
    }

    public function store(ScheduleStoreRequest $request)
    {
        $data = [
            'zone_id' => $request->get('zone_id'),
            'start_time' => $request->get('start_time'),
            'end_time' => $request->get('end_time'),
            'capacity' => $request->get('capacity'),
            'is_display' => 1,
        ];

        $zoneSchedule = $this->zoneScheduleRepository->create($data);

        if(!empty($request->get('joey_id'))){
            $joeySchedule = [
                'joey_id' => $request->get('joey_id'),
                'zone_schedule_id' => $zoneSchedule->id,
                'start_time' => $request->get('start_time')
            ];

            $this->joeyZoneScheduleRepository->create($joeySchedule);
        }


        return redirect()->route('schedule.index')->with('success', 'Schedule added successfully.');
    }

    public function edit(ZoneSchedule $schedule)
    {
        $joeys = Joey::where('on_duty', '=', 1)->whereNull('deleted_at')->get();
        $zones = Zones::all();
        $joeyZoneSchedule = JoeysZoneSchedule::with('joey')->where('zone_schedule_id',$schedule->id)->get();
        return view('front.schedule.edit', compact('joeyZoneSchedule', 'joeys', 'zones', 'schedule'));
    }

    public function update(Request $request, ZoneSchedule $schedule)
    {
//
//        $joeyZoneSchedule = JoeysZoneSchedule::with('schedule', 'joey')->where('zone_schedule_id', $schedule->id)->get();
//        dd($joeyZoneSchedule);
        $data = [
            'zone_id' => $request->get('zone_id'),
            'start_time' => ($request->get('start_time') == null) ? $schedule->start_time : $request->get('start_time'),
            'end_time' => ($request->get('end_time') == null) ? $schedule->end_time : $request->get('end_time'),
            'capacity' => $request->get('capacity'),
            'occupancy' => $schedule->occupancy + 1
        ];

        $this->zoneScheduleRepository->update($schedule->id, $data);

        $joeySchedule = [
            'joey_id' => $request->get('joey_id'),
            'zone_schedule_id' => $schedule->id,
        ];

        $joeyZoneSchedule = JoeysZoneSchedule::where('joey_id','=',$request->get('joey_id'))
        ->where('zone_schedule_id','=',$schedule->id)->get();
        ($joeyZoneSchedule->isEmpty()) ?  $this->joeyZoneScheduleRepository->create($joeySchedule) : $this->joeyZoneScheduleRepository->update($schedule->id,$joeySchedule);


        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(ZoneSchedule $schedule)
    {
        $schedule->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        $joeySchedule = JoeysZoneSchedule::where('zone_schedule_id', $schedule->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return redirect()->route('schedule.index')->with('success', 'Schedule has been removed successfully.');
    }

    public function searchSchedule(Request $request)
    {

//        if (empty($request->get('date'))) {
//            $date = date('Y-m-d');
//        } else {
            $date = $request->get('date');
            $zoneId = $request->get('zone_id');
//        }

        $allZones = Zones::all();

        $zoneSchedules = ZoneSchedule::with('zone','joeySchedule');

        if (!empty($date)) {
            $zoneSchedules = $zoneSchedules->whereDate('start_time', '=', $date);
        }

        if (!empty($zoneId)) {
            $zoneSchedules = $zoneSchedules->where('zone_id', '=', $zoneId);
        }

        if (empty($date) && empty($zoneId)) {
            $zoneSchedules = $zoneSchedules->whereDate('start_time', '=', Carbon::now());
        }


//        $joeyZoneSchedules = JoeysZoneSchedule::with('schedule', 'joey');
//        $zoneSchedules = ZoneSchedule::with('zone');
//
//        if (!empty($request->get('zone_id'))) {
//            $joeyZoneSchedules =
//                $joeyZoneSchedules->whereHas('schedule', function (Builder $query) use ($request) {
//                    $query->Where('zone_id', '=', $request->get('zone_id'));
//                });
//            $zoneSchedules = $zoneSchedules->where('zone_id', '=', $request->get('zone_id'));
//        }
//
//        if (!empty($request->get('date'))) {
//            $joeyZoneSchedules = $joeyZoneSchedules->whereHas('schedule', function (Builder $query) use ($request) {
//                    $query->WhereDate('start_time', '=', $request->get('date'));
//                });
////            $joeyZoneSchedules = $joeyZoneSchedules->whereDate('start_time', '=', $request->get('date'));
//            $zoneSchedules = $zoneSchedules->whereDate('start_time', '=', $request->get('date'));
//        }
//
//        if (empty($request->get('date')) && empty($request->get('zone_id'))) {
//            $joeyZoneSchedules = $joeyZoneSchedules->whereHas('schedule', function ($query) {
//                $query->whereDate('start_time', '=', Carbon::now());
//            });
//            $zoneSchedules = $zoneSchedules->whereDate('start_time', '=', Carbon::now());
//        }
//
//
//        $joeyZoneSchedules = $joeyZoneSchedules->paginate(10);
        $zoneSchedules = $zoneSchedules->get();

        $data = [];
        foreach($zoneSchedules as $zoneSchedule)
        {   $data[$zoneSchedule->zone_id]['name'] = $zoneSchedule->zone->name;
            $data[$zoneSchedule->zone_id]['data'][] = $zoneSchedule;

        }
//
//        dd($data);

        return view('front.schedule.index', compact('data', 'allZones', 'date', 'zoneId'));
    }

}
