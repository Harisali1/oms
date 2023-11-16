<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\OrderPostalCode;
use App\Models\OrderZoneRouting;
use App\Models\ZonesType;
use App\Repositories\Interfaces\OrderZoneRoutingRepositoryInterface;
use Illuminate\Http\Request;

class OrderZoneRoutingController extends Controller
{

    private $orderZoneRoutingRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderZoneRoutingRepositoryInterface $orderZoneRoutingRepository)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->orderZoneRoutingRepository = $orderZoneRoutingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderZones = OrderZoneRouting::with('hub', 'zoneType', 'postalCode')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('front.order-control.zone-order-routing.index', compact('orderZones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zoneTypes = ZonesType::all();
        $hubs = Hub::all();
        return view('front.order-control.zone-order-routing.add', compact('zoneTypes', 'hubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $k = $this->CheckDublicatePostalCode($request);

        if($k){
            return back()->with('error', 'Duplicate postal Code are not allowed!');
        }

        $postalCodes = array_filter($request->input('postal_code'));
        $zone = $this->orderZoneRoutingRepository->create($request->all());
        $this->storePostalCode($postalCodes, $zone);

        return redirect()
            ->route('order_zone_routing.index')
            ->with('success', 'successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderZoneRouting $orderZoneRouting)
    {
        $zoneTypes = ZonesType::all();
        $hubs = Hub::all();

        return view('front.order-control.zone-order-routing.edit',
            compact('orderZoneRouting', 'zoneTypes', 'hubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderZoneRouting $orderZoneRouting)
    {

        $data = [
            'hub_id' => $request->hub_id,
            'zone_type_id' => $request->zone_type_id,
            'title' => $request->title,
        ];

        $k = $this->CheckDublicatePostalCode($request);

        if($k){
            return back()->with('error', 'Duplicate postal Code are not allowed!');
        }

        $postalCodes = array_filter($request->input('postal_code'));
        $this->orderZoneRoutingRepository->update($orderZoneRouting->id, $data);

        $orderZoneRouting->postalCode()->delete();
        foreach($postalCodes as $codes){
            $code = [
                'zone_id' => $orderZoneRouting->id,
                'postal_code' => $codes
            ];

            OrderPostalCode::create($code);
        }

        return redirect()
            ->route('order_zone_routing.index')
            ->with('success', 'successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderZoneRouting $orderZoneRouting)
    {
        $this->orderZoneRoutingRepository->delete($orderZoneRouting->id);
        return redirect()
            ->route('order_zone_routing.index')
            ->with('success', 'successfully!');
    }



    public function CheckDublicatePostalCode($request)
    {
        $array = [];
        $k = 0;
        foreach ($request->get('postal_code') as $value) {
            if (!isset($array[$value])) {
                $array[$value] = 1;
            } else {
                $k = 1;
                break;
            }
        }
        return $k;
    }

    private function storePostalCode($postalCodes, $zone)
    {
        foreach($postalCodes as $codes){
            $code = [
                'zone_id' => $zone->id,
                'postal_code' => $codes
            ];
            OrderPostalCode::create($code);
        }
    }
}
