<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CategoryControlRequest;
use App\Models\DeliveryPreference;
use App\Models\DeliveryType;
use App\Models\OrderCategory;
use App\Models\OrderZone;
use App\Models\ZoneRouting;
use App\Repositories\Interfaces\OrderCategoryRepositoryInterface;
use Illuminate\Http\Request;

class OrderCategoryController extends Controller
{
    private $orderCategoryRepository;

    /**
     * Create a new controller instance.
     *
     * @param OrderCategoryRepositoryInterface $orderCategoryRepository
     */
    public function __construct(OrderCategoryRepositoryInterface $orderCategoryRepository)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->orderCategoryRepository = $orderCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $orderCategories = OrderZone::with(
            'category',
            'category.deliveryType',
            'category.deliveryPreference',
            'category.orderCategoryZone'
        )->orderBy('id', 'DESC')->paginate(10);

        return view('front.order-control.order-category.index', compact('orderCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {

        $order = OrderZone::pluck('order_category_id');
        $orderCategories = OrderCategory::whereNotIn('id', $order)->get();
        $zones = ZoneRouting::all();
        $deliveryTypes = DeliveryType::all();
        $deliveryPreferences = DeliveryPreference::all();
        return view('front.order-control.order-category.add', compact(
                'deliveryTypes',
                'deliveryPreferences',
                'zones',
                'orderCategories'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryControlRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryControlRequest $request)
    {
        foreach ($request->get('order_category_id') as $cat_id) {
            $time = [
                'order_category_id' => $cat_id,
                'start_time' => $request->get('start_time'),
                'end_time' => $request->get('end_time'),
            ];

            OrderZone::create($time);
        }

        foreach ($request->get('order_category_id') as $cat_id) {
            $order = OrderCategory::find($cat_id);
            $order->deliveryType()->attach($request->get('delivery_type_id'));
            $order->orderCategoryZone()->attach($request->get('zone_id'));
            $order->deliveryPreference()->attach($request->get('delivery_preference_id'));
        }

        return redirect()
            ->route('order_category.index')
            ->with('success', 'Category control added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OrderZone $order_category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @internal param int $id
     */
    public function edit(OrderZone $order_category)
    {

        $orderZone = OrderZone::with('category', 'category.deliveryType', 'category.deliveryPreference', 'category.orderCategoryZone')->find($order_category->id);
        $orderCategories = OrderCategory::all();
        $zones = ZoneRouting::all();
        $deliveryTypes = DeliveryType::all();
        $deliveryPreferences = DeliveryPreference::all();
        return view('front.order-control.order-category.edit', compact(
            'orderZone',
            'deliveryTypes',
            'deliveryPreferences',
            'zones',
            'orderCategories'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param OrderZone $order_category
     * @return \Illuminate\Http\RedirectResponse
     * @internal param int $id
     */
    public function update(Request $request, OrderZone $order_category)
    {

        foreach ($request->get('order_category_id') as $cat_id) {
            $time = [
                'order_category_id' => $cat_id,
                'start_time' => $request->get('start_time'),
                'end_time' => $request->get('end_time'),
            ];

            $orderZone = OrderZone::whereOrderCategoryId($cat_id)->get();
            if (count($orderZone) > 0) {
                $timed = OrderZone::find($orderZone[0]->id);
                $timed->delete();
            }

            OrderZone::create($time);
        }

        foreach ($request->get('order_category_id') as $cat_id) {
            $order = OrderCategory::find($cat_id);

            $order->deliveryType()->detach();
            $order->deliveryPreference()->detach();
            $order->orderCategoryZone()->detach();

            $order->deliveryType()->attach($request->get('delivery_type_id'));
            $order->orderCategoryZone()->attach($request->get('zone_id'));
            $order->deliveryPreference()->attach($request->get('delivery_preference_id'));
        }

        return redirect()
            ->route('order_category.index')
            ->with('success', 'Category control updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OrderZone $order_category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OrderZone $order_category)
    {
        $orderZone = OrderZone::whereOrderCategoryId($order_category->order_category_id)->get();
        if (count($orderZone) > 0) {
            $timed = OrderZone::find($orderZone[0]->id);
            $timed->delete();
        }

        $order = OrderCategory::find($order_category->order_category_id);
        $order->deliveryType()->detach();
        $order->deliveryPreference()->detach();
        $order->orderCategoryZone()->detach();

        return redirect()
            ->route('order_category.index')
            ->with('success', 'Category control has removed successfully.');
    }
}
