<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\JoeyLocation;
use App\Models\JoeyRouteLocation;
use App\Models\JoeyRoutes;
use App\Models\JoeyRoutificJob;
use App\Models\Joey;
use App\Models\JoeyRoutificJobLocation;
use App\Models\JoeyRoutificJobRoute;
use App\Models\Location;
use App\Models\SprintTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $joeys = Joey::where('on_duty', '=', 1)->whereNull('deleted_at')->get();
        return view('front.jobs.job-map-view', compact('joeys'));
    }

    public function jobRoutes($id)
    {

        $joey = Joey::find($id);

        if($joey == null){
            return json_encode(['output' => '', 'message' => 'this joey has not exists' ]);
        }

        $joeyRoute = JoeyRoutes::where('joey_id', $joey->id)->where('route_completed', 0)->first();

        if($joeyRoute == null){
            return json_encode(['output' => '', 'message' => 'This joey has no route']);
        }

        $joeyLocation = JoeyLocation::where('joey_id', $joey->id)->orderBy('id', 'DESC')->first();
        if($joeyLocation == null){
            return json_encode(['output' => '', 'message' => 'Please update this joey location first']);
        }

        $joeyLat = $joeyLocation->latitude/1000000;
        $joeyLng = $joeyLocation->longitude/1000000;

        $routeId = $joeyRoute->id;

        $routes = $this->joeyRouteLocationDataQuery($joey);

        $sequenceRoute = $this->sequenceRoute($routes, $joeyLat, $joeyLng, $joey, $routeId);

//        dd($sequenceRoute);
//        $saveDispatchRoute = $this->saveDispatchRoute($sequenceRoute);

//        $routes = JoeyRoutificJobRoute::whereJoeyId($id)->whereNull('deleted_at')->pluck('id');
//        $jobs = JoeyRoutificJobLocation::whereIn('route_id', $routes)
//            ->whereNull('deleted_at')->get();

        $response = [];

        foreach ($sequenceRoute as $key => $route) {
            $task = SprintTask::where('id', $route['task_id'])->whereNull('deleted_at')->first();
//            foreach ($tasks as $key => $task) {
                $location = Location::find($task->location_id);
                $response[$task->id] = [
                    'location_id' => $location->id,
                    'lat' => substr($location->latitude,0,8) / 1000000,
                    'lng' => substr($location->longitude,0,9) / 1000000,
                    'location_name' => $location->address,
                    'type' => $task->type,
                    'sprint_id' => $task->sprint_id,
                    'key' =>$key
                ];
//            }
        }
//
        $result = array_values($response);
//
        return json_encode([ "output" => $result, 'message' => 'This joey has no route' ]);


    }

    public function joeyRouteLocationDataQuery(Joey $joey)
    {
        $routeIds = JoeyRoutes::where('joey_id',$joey->id)->where('mile_type',6)->whereNull('deleted_at')->pluck('id')->toArray();

        $routes = JoeyRouteLocation::whereIn('route_id',$routeIds)
            ->whereHas('sprintTask', function (Builder $query) {
                $query->whereNull('deleted_at');
            })
            ->whereHas('sprintTask.sprintsSprintsForRoute', function (Builder $query) {
                $query->whereNull('deleted_at');
            })
            ->whereNull('deleted_at')->whereNull('is_unattempted')->get();

        return $routes;
    }

    public function sequenceRoute($routes, $joeyLat, $joeyLng, $joey, $routeIdForDispatchRoute)
    {
        $optimizeTask = [];
        $ordinal = 0;
        $joeyDistance=0;
        foreach ($routes as $route_key => $route) {
            $ordinal++;

            if(isset($route->sprintTask->location_id)){

                $location = Location::where('id',$route->sprintTask->location_id)->first();

                $taskLatitude = (float)substr($location->latitude, 0, 8) / 1000000;
                $taskLongitude = (float)substr($location->longitude, 0, 8) / 1000000;

                // Distance Matrix Api implement for lat lng distances
                $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=$taskLatitude,$taskLongitude&origins=$joeyLat,$joeyLng&key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0";
                // response get from file content
                $resp_json = file_get_contents($url);
                // decode the json
                $resp = json_decode($resp_json, true);
                // if status is ok then get distance

                if($resp['status']=='OK'){
                    if(isset($resp['rows'][0]['elements'][0])){
                        if($resp['rows'][0]['elements'][0]['status'] == 'OK'){
                            $joeyDistance = $resp['rows'][0]['elements'][0]['distance']['text'];
                        }else{
                            $joeyDistance = 0;
                        }
                    }
                }

                //explode distance from km
                $joeyDistance = explode(" ",$joeyDistance);

                if($joeyDistance[0] != 0){
                    $optimizeTask[] = [
                        'joey_id'       => $joey->id,
                        'route_id'      => $routeIdForDispatchRoute,
                        'task_id'       => $route->sprintTask->id,
                        'ordinal'       => $ordinal,
                        'task_loc_lat'  => $taskLatitude,
                        'task_loc_lng'  => $taskLongitude,
                        'distance'      => $joeyDistance[0],
                        'type'          => $route->sprintTask->type,
                    ];
                }
            }
        }

        usort($optimizeTask, function($a, $b) { return $b['distance'] < $a['distance'];});

        return $optimizeTask;
    }

//    public function saveDispatchRoute($routesData)
//    {
//        foreach($routesData as $data){
//
//        }
//    }
}
