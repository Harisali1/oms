<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\DeliveryTypeStoreRequest;
use App\Http\Requests\Front\DeliveryTypeUpdateRequest;
use App\Models\DeliveryType;
use App\Repositories\Interfaces\DeliveryTypeRepositoryInterface;
use Carbon\Carbon;

class DeliveryTypeController extends Controller
{

    private $deliveryTypeRepository;

    /**
     * Create a new controller instance.
     *
     * @param DeliveryTypeRepositoryInterface $deliveryTypeRepository
     */
    public function __construct(DeliveryTypeRepositoryInterface $deliveryTypeRepository)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->deliveryTypeRepository = $deliveryTypeRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveryTypes =  DeliveryType::orderBy('id','DESC')->paginate(10);
        return view('front.order-control.delivery-type.index', compact('deliveryTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.order-control.delivery-type.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryTypeStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeliveryTypeStoreRequest $request)
    {

        $this->deliveryTypeRepository->create($request->all());
        return redirect()
            ->route('delivery_type.index')
            ->with('success', 'Delivery type added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort('401');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeliveryType $deliveryType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @internal param int $id
     */
    public function edit(DeliveryType $deliveryType)
    {
        return view('front.order-control.delivery-type.edit', compact('deliveryType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeliveryTypeUpdateRequest $request
     * @param DeliveryType $deliveryType
     * @return \Illuminate\Http\RedirectResponse
     * @internal param int $id
     */
    public function update(DeliveryTypeUpdateRequest $request, DeliveryType $deliveryType)
    {
        $this->deliveryTypeRepository->update($deliveryType->id, $request->only('title'));
        return redirect()
            ->route('delivery_type.index')
            ->with('success', 'Delivery type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeliveryType $deliveryType
     * @return \Illuminate\Http\RedirectResponse
     * @internal param int $id
     */
    public function destroy(DeliveryType $deliveryType)
    {
        $deliveryType->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
//        $this->deliveryTypeRepository->delete($deliveryType->id);
        return redirect()
            ->route('delivery_type.index')
            ->with('success', 'Delivery type has been removed successfully.');
    }

    public function status(DeliveryType $deliveryType)
    {
        $deliveryType->update([
            'status' => !$deliveryType->status
        ]);
        return redirect()
            ->route('delivery_type.index')
            ->with('success', 'Delivery type status changed successfully.');
    }
}
