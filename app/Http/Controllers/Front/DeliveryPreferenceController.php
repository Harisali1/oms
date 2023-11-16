<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\DeliveryPreferenceStoreRequest;
use App\Http\Requests\Front\DeliveryPreferenceUpdateRequest;
use App\Models\DeliveryPreference;
use App\Repositories\Interfaces\DeliveryPreferenceRepositoryInterface;

class DeliveryPreferenceController extends Controller
{
    private $deliveryPreferenceRepository;

    /**
     * Create a new controller instance.
     *
     * @param DeliveryPreferenceRepositoryInterface $deliveryPreferenceRepository
     */
    public function __construct(DeliveryPreferenceRepositoryInterface $deliveryPreferenceRepository)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->deliveryPreferenceRepository = $deliveryPreferenceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $deliveryPreferences = DeliveryPreference::orderBy('id', 'DESC')->paginate(10);
        return view('front.order-control.delivery-preference.index', compact('deliveryPreferences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('front.order-control.delivery-preference.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryPreferenceStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeliveryPreferenceStoreRequest $request)
    {

        $this->deliveryPreferenceRepository->create($request->all());
        return redirect()
            ->route('delivery_preference.index')
            ->with('success', 'Delivery preference added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort('401');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeliveryPreference $deliveryPreference
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @internal param int $id
     */
    public function edit(DeliveryPreference $deliveryPreference)
    {
        return view('front.order-control.delivery-preference.edit', compact('deliveryPreference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeliveryPreferenceUpdateRequest $request
     * @param DeliveryPreference $deliveryPreference
     * @return \Illuminate\Http\RedirectResponse
     * @internal param int $id
     */
    public function update(DeliveryPreferenceUpdateRequest $request, DeliveryPreference $deliveryPreference)
    {
        $this->deliveryPreferenceRepository->update($deliveryPreference->id, $request->only('title'));
        return redirect()
            ->route('delivery_preference.index')
            ->with('success', 'Delivery preference updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeliveryPreference $deliveryPreference
     * @return \Illuminate\Http\RedirectResponse
     * @internal param int $id
     */
    public function destroy(DeliveryPreference $deliveryPreference)
    {
        $deliveryPreference->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
//        $this->deliveryPreferenceRepository->delete($deliveryPreference->id);
        return redirect()
            ->route('delivery_preference.index')
            ->with('success', 'Delivery preference has been removed successfully.');
    }

    public function status(DeliveryPreference $deliveryPreference)
    {
        $deliveryPreference->update([
            'status' => !$deliveryPreference->status
        ]);
        return redirect()
            ->route('delivery_preference.index')
            ->with('success', 'Delivery preference changed status successfully.');
    }
}
