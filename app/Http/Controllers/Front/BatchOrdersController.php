<?php

namespace App\Http\Controllers\Front;

use App\Classes\BatchClient;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchOrder;
use App\Models\ExclusiveOrderJoey;
use App\Models\Joey;
use App\Models\Location;
use App\Models\Sprint;
use App\Models\SprintTask;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class BatchOrdersController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:web');
        parent::__construct();

    }


    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        $vendor = Vendor::all();
        if ($request->get('date')) {
            $date = $request->get('date');
        } else {
            $date = date('Y-m-d');
        }
        $batchOrdersData = Batch::join('betch_orders', 'betch.id', '=', 'betch_orders.betch_id')
            ->join('sprint__tasks', 'betch_orders.order_id', '=', 'sprint__tasks.sprint_id')
            ->where('sprint__tasks.type', '=', 'dropoff')
            ->where('betch.betch_order_date', $date)
            ->whereNull('betch_orders.deleted_at');
        if ($request->get('VendorName')) {
            $batchOrdersData = $batchOrdersData->where('betch.store_num', '=', $request->get('VendorName'));
        }
        $batchOrders = $batchOrdersData->orderby('betch.id')->get(['betch.*', 'betch_orders.order_id', 'betch_orders.distance', 'betch_orders.id as Batchorder_id', 'sprint__tasks.location_id', 'sprint__tasks.contact_id']);


        return view('front.batch-orders.index', compact('batchOrders', 'date', 'vendor'));
    }

    /**
     * Render Model postal code create table view
     */
    public function batchCreateModelHtmlRender()
    {
        $Vendor_name = Vendor::whereNull('deleted_at')->get();
        $html = view('front.batch-orders.ajax-render-view-batch-create-model', compact('Vendor_name'))->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    public function CreateBatch(Request $request)
    {

        $start_time = $request['sprint_order_dt_start'];
        $end_time = $request['sprint_order_dt_end'];
        $sprint_order_dt = $request['sprint_order_dt'];
        $sprint_order_dt_start = $sprint_order_dt . ' ' . $start_time;
        $sprint_order_dt_end = $sprint_order_dt . ' ' . $end_time;

        $store_num = $request['store_num'];


        $start_dateTimeUTC= ConvertTimeZone($sprint_order_dt_start,'UTC','America/Toronto');
        $end_dateTimeUTC= ConvertTimeZone($sprint_order_dt_end,'UTC','America/Toronto');
        $orders = Sprint::join('sprint__tasks', 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
            ->join('merchantids', 'merchantids.task_id', '=', 'sprint__tasks.id')
            //          ->where(DB::raw("FROM_ UNIXTIME (sprint__tasks.due_time, '%Y-%m-%d' )", "LIKE", $sprint_order_dt . '%'))
            ->where('sprint__tasks.type', '=', 'dropoff')
            ->where('sprint__sprints.creator_id', '=', $store_num)
            ->wherein('sprint__sprints.status_id', [24, 61])
            ->whereBetween(DB::raw("FROM_UNIXTIME(sprint__tasks.due_time)"), [ $start_dateTimeUTC , $end_dateTimeUTC ])
//            ->where(DB::raw("FROM_UNIXTIME(sprint__tasks.due_time)"), '<=', $sprint_order_dt_end)
            ->orderby('sprint__tasks.due_time')
            ->get(['sprint__sprints.id', 'sprint__tasks.due_time', 'sprint__tasks.location_id', 'sprint__tasks.id as task_id', 'sprint__sprints.creator_id', 'sprint__sprints.created_at', 'sprint__sprints.distance', 'merchantids.start_time', 'merchantids.end_time'])
            ->toArray();

        if (empty($orders)) {
            Session::flash('error', 'No orders found');
            return Redirect::back();
        }
        $vendor = Vendor::find($store_num);
        $vendor_address = $vendor->vendorLocationId->address;

        $lat[0] = substr( $vendor->vendorLocationId->latitude, 0, 2);
        $lat[1] = substr($vendor->vendorLocationId->latitude, 2);
        $vendor_latitude  = $lat[0] . "." . $lat[1];

        $long[0] = substr ($vendor->vendorLocationId->longitude, 0, 3);
        $long[1] = substr( $vendor->vendorLocationId->latitude, 3);
        $vendor_longitude = $long[0] . "." . $long[1];

        foreach ($orders as $key => $value) {

            $order_id = BatchOrder::where('order_id', $orders[$key]['id'])->pluck('order_id');
            $countOrder = count($order_id);
            if (!empty($orders[$key]['start_time'] && $orders[$key]['end_time']) && $orders[$key]['start_time'] == $value['start_time'] && $orders[$key]['end_time'] == $value['end_time'] && $order_id->isEmpty()) {
                $time = $value['start_time'] . '-' . $value['end_time'];
                $location = Location::find($value['location_id']);

                $lat[0] = substr($location->latitude, 0, 2);
                $lat[1] = substr($location->latitude, 2);
                $latitude = $lat[0] . "." . $lat[1];

                $long[0] = substr($location->longitude, 0, 3);
                $long[1] = substr($location->longitude, 3);
                $longitude = $long[0] . "." . $long[1];

                $windows[$time][] = [
                    'id' => $value['id'],
                    'betch_order_date' => date("Y-m-d h:i", $value['due_time']),
                    'task_id' => $value['task_id'],
                    'start_time' => $value['start_time'],
                    'end_time' => $value['end_time'],
                    'creator_id' => $value['creator_id'],
                    'distance' => $value['distance'],
                    'due_time' => $value['due_time'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];

            }
        }

        if (empty($windows)) {
            Session::flash('error', 'No order found to be created');
            return Redirect::back();
        }


        foreach ($windows as $key => $data) {

            $more_shifts = 1;
            $count_shifts = 0;
            unset($visits);
            unset($shifts);
            foreach ($data as $x) {

                $count_shifts++;
                $visits[$x['id']] = [
                    "location" => array(
                        "name" => (string)$x['task_id'],
                        "lat" => $x['latitude'],
                        "lng" => $x['longitude']
                    ),
                    "start" => $x['start_time'],
                    "end" => $x['end_time'],
                ];

                if ($count_shifts > 2 || $count_shifts == 1) {
                    $more_shifts++;
                }
                $shifts[$more_shifts] = array(
                    "start_location" => array(
                        "id" => $store_num,
                        "name" => $vendor_address,
                        "lat" => $vendor_latitude,
                        "lng" => $vendor_longitude
                    ),
                    "end_location" => array(
                        "id" => $store_num,
                        "name" => $vendor_address,
                        "lat" => $vendor_latitude,
                        "lng" => $vendor_longitude
                    ),
                    "shift_start" => $x['start_time'],
                    "shift_end" => $x['end_time'],
                    "capacity" => 2,
                    "min_visits_per_vehicle" => 2,
                );

            }

            $options = array(
                "shortest_distance" => true,
                "polylines" => true
            );
            $payload = array(
                "visits" => $visits,
                "fleet" => $shifts,
                "options" => $options
            );

            $client = new BatchClient('/vrp');
            $client->setData($payload);
            $apiResponse = $client->send();

            if (!empty($apiResponse->error)) {

                $error = new LogRoutes();
                $error->error = $apiResponse->error;
                $error->save();
                Session::flash('status_error', $apiResponse->error);
                return Redirect::back();

            }
            $solutions = $apiResponse->solution;
            foreach ($solutions as $solution) {
                $sliced = array_slice($solution, 1, -1);
                if (!empty($sliced)) {
                    $newarray[] = $sliced;
                }
            }

        }

        DB::beginTransaction();

        try {
            $batch_count = 0;
            $order_count = 0;
            foreach ($newarray as $item) {
                $betch = new Batch();

                if (!empty($item)) {
                    $betch['store_num'] = $store_num;

                    $windows = SprintTask::where('sprint_id', $item[0]->location_id)->where('type', '=', 'dropoff')->first();
                    $start_time = $windows->merchant[0]->start_time;
                    $end_time = $windows->merchant[0]->end_time;

                    $betch['end_time'] = $end_time;
                    $betch['start_time'] = $start_time;
                    $betch['betch_order_date'] = $sprint_order_dt;

                    $betch->status = "unassigned";
                    $betch->save();

                    unset($betch_order);

                    foreach ($item as $order) {

                        $betch_order = new BatchOrder();
                        $betch_order['betch_id'] = $betch->id;
                        $betch_order['order_id'] = $order->location_id;
                        $betch_order['distance'] = $order->distance;

                        $betch_order->save();
                        $order_count++;
                        DB::commit();
                    }
                }
                $batch_count++;
            }
        } catch (Exception $e) {
            DB::rollback();
        }

        if ($batch_count == 0) {
            Session::flash('error', 'No order found to be created');
        } else {
            Session::flash('success', ' Successfully Created ' . $batch_count . ' Batches of total ' . $order_count . ' orders');
        }
        return Redirect::route('batch-order.index');
    }

    public function AssigntoJoey(Request $request)
    {
        $batchId = $request->BatchId;
        $joeys = Joey::whereNull('deleted_at')
            ->where('is_enabled', '=', 1)
            ->whereNull('email_verify_token')
            ->whereNOtNull('plan_id')
            ->orderBy('first_name')
            ->get();

        $html = view('front.batch-orders.ajax-render-assign-to-joey-modal', compact('joeys', 'batchId'))->render();
        return response()->json(['status' => true, 'html' => $html]);
    }

    public function CreateBatchAssign(Request $request)
    {
        $batchId = $request->batch_id;
        $joey = $request->joey_id;
        if ($request->get('date')) {
            $date = $request->get('date');
        } else {
            $date = date('Y-m-d');
        }
        $batchTable = Batch::find($batchId);

        $data = [
            'joey_id' => $joey,
        ];

        $batchTable->update($data);
        $batch_order_id = BatchOrder::where('betch_id', $batchId)->pluck('order_id');

        foreach ($batch_order_id as $data) {
            $exlusiveData = [
                'order_id' => $data,
                'joey_id' => $joey,
            ];

            ExclusiveOrderJoey::create($exlusiveData);

        }

        Session::flash('success', 'Batch Assigned Successfully');
        return Redirect::route('batch-order.index', compact('date'));
    }

    public function transferBatchView(Request $request)
    {

        $batchId = $request->BatchId;
        Batch::where('id', $batchId)->get('joey_id');

        $joeys = Joey::whereNull('deleted_at')
            ->where('is_enabled', '=', 1)
            ->whereNull('email_verify_token')
            ->whereNOtNull('plan_id')
            ->orderBy('first_name')
            ->get();

        $html = view('front.batch-orders.ajax-render-view-transfer-batch-model', compact('joeys', 'batchId'))->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    public function transferBatch(Request $request)
    {
        $joey = $request->joey_id;
        $batchId = $request->batch_id;

        $batchTable = Batch::find($batchId);

        if (empty($batchTable->joeys)) {
            Session::flash('error', 'Please assign Batch first');
            return Redirect::route('batch-order.index');
        }

        $batchOrder = BatchOrder::where('betch_id', $batchId)->get();
        $orderIdExist = $batchOrder->pluck('order_id')->toArray();

        //delete existing
        if (isset($orderIdExist)) {
            ExclusiveOrderJoey::whereIn('order_id', $orderIdExist)->where('joey_id', $batchTable->joey_id)->delete();
        }
        $data = [
            'joey_id' => $joey,
        ];
        $batchTable->update($data);
        $batch_order_id = BatchOrder::where('betch_id', $batchId)->pluck('order_id');

        foreach ($batch_order_id as $data) {
            $exlusiveData = [
                'order_id' => $data,
                'joey_id' => $joey,
            ];

            ExclusiveOrderJoey::create($exlusiveData);

        }

        Session::flash('success', 'Batch Transfer Successfully');
        return Redirect::route('batch-order.index');
    }

    public function editBatch($id, Request $request)
    {

        //find batch id
        $batchId = Batch::find($id);
        $store_num = $batchId->store_num;
        //get the value batch order based on batch_id
        $BatchOrderData = BatchOrder::where('betch_id', $id)->get();

        return view('front.batch-orders.edit', compact('batchId', 'BatchOrderData', 'store_num'));
    }

    public function ajaxedit(Request $request)
    {

        if ($request->get('date')) {

            $date = $request->get('date');

        } else {
            $date = date('y-m-d');
        }

        $orderId = BatchOrder::get('order_id');
        $data = Sprint::join('sprint__tasks', 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
            ->where('sprint__tasks.type', '=', 'dropoff')->where('sprint__sprints.creator_id', $request->storenum)
            ->where(DB::raw("DATE_FORMAT(FROM_UNIXTIME(sprint__tasks.due_time), '%Y-%m-%d')"), "LIKE", $date . '%')
            ->wherein('sprint__tasks.status_id', [24, 61])->whereNotIn('sprint__sprints.id', $orderId)->whereNull('sprint__tasks.deleted_at')->pluck('sprint__tasks.sprint_id');

        return response()->json(['status' => true, 'body' => $data]);

    }

    public function updateEditBatch(Request $request)
    {

        //delete old data
        $orderId = $request->oldvalue;

//

        $newVal = $request->SprintOrders;
//check for new values if it presented it is presented save it in new variable
        $finalValues = array_diff($newVal, $orderId);

        if (empty($finalValues)) {
            Session::flash('success', 'No Changes were made');
            return Redirect::route('batch-order.index');
        } else {
            //find the old value and then remove it
            $removing_value = array_diff($orderId, $newVal);
            BatchOrder::whereIn('order_id', $removing_value)->delete();


            $orders = Sprint::join('sprint__tasks', 'sprint__sprints.id', '=', 'sprint__tasks.sprint_id')
                ->join('merchantids', 'merchantids.task_id', '=', 'sprint__tasks.id')
                ->where('sprint__tasks.type', '=', 'dropoff')
                ->wherein('sprint__tasks.sprint_id', $finalValues)
                ->orderby('sprint__tasks.due_time')
                ->get(['sprint__sprints.id', 'sprint__sprints.distance'])
                ->toArray();

            foreach ($orders as $order) {

                $data = [
                    'betch_id' => $request->id,
                    'order_id' => $order['id'],
                    'distance' => $order['distance'],
                ];
                BatchOrder::create($data);
            }
            Session::flash('success', 'Batches were updated successfully');
            return Redirect::route('batch-order.index');
        }

    }

    public function Map(Request $request)
    {
        $batchId = Batch::find($request->Batchid);
        $batchData = Sprint::where('creator_id', $batchId->store_num)->first();

        //get vendor latitude and longitude
        if (isset($batchData->vendor->vendorLocationId)) {
            $latitude = $batchData->Vendor->vendorLocationId->latitude;
            $longitude = $batchData->Vendor->vendorLocationId->longitude;
            $vendorLocation = $batchData->Vendor->vendorLocationId;
            $vendorName = $batchData->Vendor->name;

            if (isset($latitude) && isset($longitude)) {

                $lat[0] = substr($latitude, 0, 2);
                $lat[1] = substr($latitude, 2);
                $Vlatitude = $lat[0] . "." . $lat[1];

                $long[0] = substr($longitude, 0, 3);
                $long[1] = substr($longitude, 3);
                $Vlongitude = $long[0] . "." . $long[1];
            }
            $BatchOrderData = BatchOrder::where('betch_id', $request->Batchid)->get();

            if (count($BatchOrderData) > 1) {
                //  drop-off latitude and longitude
                $location_one = $BatchOrderData[0]->dropoffLocation->location;
                $dropoff_address_one = $location_one->address . ', ' . $location_one->city->name . ' , ' . $location_one->postal_code;

                if (isset($location_one)) {


                    if (isset($location_one->id)) {

                        $lat[0] = substr($location_one->latitude, 0, 2);
                        $lat[1] = substr($location_one->latitude, 2);
                        $dropOfflatitude_one = $lat[0] . "." . $lat[1];

                        $long[0] = substr($location_one->longitude, 0, 3);
                        $long[1] = substr($location_one->longitude, 3);
                        $droplongitude_one = $long[0] . "." . $long[1];
                    }
                }
                $location_two = $BatchOrderData[1]->dropoffLocation->location;
                $dropoff_address_two = $location_two->address . ', ' . $location_two->city->name . ' , ' . $location_two->postal_code;

                if (isset($location_two)) {
                    $lat[0] = substr($location_two->latitude, 0, 2);
                    $lat[1] = substr($location_two->latitude, 2);
                    $dropOfflatitude_two = $lat[0] . "." . $lat[1];

                    $long[0] = substr($location_two->longitude, 0, 3);
                    $long[1] = substr($location_two->longitude, 3);
                    $droplongitude_two = $long[0] . "." . $long[1];


                }
                $address['one'] = $dropoff_address_one;
                $address['two'] = $dropoff_address_two;

                $html = view('front.batch-orders.Map', compact('address', 'vendorName', 'vendorLocation', 'Vlatitude', 'Vlongitude', 'droplongitude_one', 'dropOfflatitude_one', 'droplongitude_two', 'dropOfflatitude_two', 'dropoff_address_one', 'dropoff_address_two'))->render();
                return response()->json(['status' => true, 'html' => $html]);

            } else {
                //  drop-off latitude and longitude
                $location_one = $BatchOrderData[0]->dropoffLocation->location;
                $dropoff_address_one = $location_one->address . ', ' . $location_one->city->name . ' , ' . $location_one->postal_code;

                if (isset($location_one)) {
                    if (isset($location_one->id)) {
                        $lat[0] = substr($location_one->latitude, 0, 2);
                        $lat[1] = substr($location_one->latitude, 2);
                        $dropOfflatitude_one = $lat[0] . "." . $lat[1];

                        $long[0] = substr($location_one->longitude, 0, 3);
                        $long[1] = substr($location_one->longitude, 3);
                        $droplongitude_one = $long[0] . "." . $long[1];
                    }
                }
                $html = view('front.batch-orders.Map', compact('vendorName', 'vendorLocation', 'Vlatitude', 'Vlongitude', 'droplongitude_one', 'dropOfflatitude_one', 'dropoff_address_one'))->render();
                return response()->json(['status' => true, 'html' => $html]);
            }
        }
    }

    public function deleteBatch(Request $request)
    {
        $batcOrderDelete = BatchOrder::where('order_id', $request->order_id)->delete();

        Session::flash('success', 'Batch Unassigned Successfully');
        return Redirect::route('batch-order.index');
    }

    public function viewDeletebatch(Request $request)
    {
        $order_id = $request->order_id;
        $html = view('front.batch-orders.ajax-render-delete-modal', compact('order_id'))->render();
        return response()->json(['status' => true, 'html' => $html]);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $batcOrderDelete = BatchOrder::whereIn('id', explode(",", $ids))->delete();

        return response()->json(['success' => "Batches has been deleted."]);
    }

    private function make_similar_batches($orders)
    {
        if (count($orders) > 1) {
            for ($i = 0; $i < count($orders); $i++) {

                if (count($orders) > $i + 1) {
                    if ($orders[$i]['due_time'] == $orders[$i + 1]['due_time']) {
                        $this->create_batch_record([$orders[$i], $orders[$i + 1]]);
                        unset($orders[$i]);
                        unset($orders[$i + 1]);
                        $i++;
                    }
                }
            }
        }

        $orders = $this->reindex_array($orders);

        return $orders;
    }

    private function create_batch_record($orders)
    {

        DB::beginTransaction();

        $betch = new Batch();
        try {
            foreach ($orders as $x) {
                $betch['store_num'] = $x['creator_id'];

                $betch['end_time'] = $x['end_time'];
                $betch['start_time'] = $x['start_time'];
                $betch['betch_order_date'] = $x['betch_order_date'];

                //check for order in BatchOrders if not exist it will create a batch order and if exist it will ignore it
                $order_id = BatchOrder::where('order_id', $x['id'])->pluck('order_id');
            }

            //check for value
            if ($order_id->isEmpty()) {
                $betch->status = "unassigned";
                $betch->save();

                foreach ($orders as $order) {
                    $betch_order = new BatchOrder();
                    $betch_order['betch_id'] = $betch->id;
                    $betch_order['order_id'] = $order['id'];
                    $betch_order['distance'] = $order['distance'];

                    $betch_order->save();

                    DB::commit();
                }
            }
        } catch (Exception $e) {
            DB::rollback();

        }
    }

    private function reindex_array($orders)
    {
        $n = [];
        foreach ($orders as $order) {
            $n[] = $order;

        }
        return $n;
    }
}

