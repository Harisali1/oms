<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\AdditionalInformationRequest;
use App\Http\Requests\Front\PersonalInformationRequest;
use App\Http\Requests\Front\UpdateJoeyRequest;
use App\Http\Requests\Front\VehicleInformationRequest;
use App\Http\Requests\Front\WorkPreferencesRequest;
use App\Models\City;
use App\Models\JoeyDeposit;
use App\Models\JoeyMetaData;
use App\Models\JoeyVehicle;
use App\Models\Location;
use App\Models\PreferWorkTime;
use App\Models\PreferWorkType;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zones;
use App\Models\ZoneSchedule;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JoeyController extends Controller
{

    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {

        $this->middleware('auth:web');
        parent::__construct();
        $this->userRepository = $userRepository;

    }

    /**
     * Joey Signup Success view
     *
     */
    public function signupSuccess()
    {
        $joey = auth()->user();
        if ($joey->is_active == 0) {
            $record = $this->userRepository->find($joey->id);
            $status = [
                'personal' => 1,
                'vehicle' => 2,
                'work' => 2,
                'additional' => 2,
                'all' => 2
            ];
            if ($record->location_id == 1)
            {
                $status['personal'] = 1;
            }
            else
            {
                if ($record->joeyVehicle == null){
                    $status['personal'] = 3;
                    $status['vehicle'] = 1;
                }
                else{
                    if($record->preferred_zone_id == null) {
                        $status['personal'] = 3;
                        $status['vehicle'] = 3;
                        $status['work'] = 1;
                    }
                    else{
                        if($record->joeyDeposit == null) {
                            $status['personal'] = 3;
                            $status['vehicle'] = 3;
                            $status['work'] = 3;
                            $status['additional'] = 1;
                        }
                        else{
                            $status['personal'] = 3;
                            $status['vehicle'] = 3;
                            $status['work'] = 3;
                            $status['additional'] = 3;
                            $status['all'] = 1;
                        }
                    }
                }

            }

            return view('front.signup-success', compact('record', 'status'));
        } else {
            return Redirect::to('profile');
        }

    }

    /**
     * Joey Personal Information view
     *
     */
    public function personalInformation()
    {
        $record = $this->userRepository->find(auth()->user()->id);
        $status = [
            'personal' => 1,
            'vehicle' => 2,
            'work' => 2,
            'additional' => 2
        ];
        return view('front.signup-step1', compact('record', 'status'));
    }

    /**
     * Joey Personal Information Create
     *
     */
    public function personalInformationCreate(PersonalInformationRequest $request)
    {
        $input = $request->all();
        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );
        $city = $input['city_id'];
        //Check city exist or not
        $cities_data = City::where('name', $city)->first();
        if (empty($cities_data) || $city == '' || $city == null) {
            return response()->json(['status' => false, 'message' => 'Wrong address please enter correct address']);
        }

        //check condition for actual longitude
        $lng = strlen((int)$data['longitude']);

        $latitude = str_replace(".", "", $data['latitude']);
        $latitudes = (strlen($latitude) > 10) ? (int)substr($latitude, 0, 9) : (int)$latitude;
        if ($lng == 4) {
            $longitude = str_replace(".", "", $data['longitude']);
            $longitudes = (strlen($longitude) > 10) ? (int)substr($longitude, 0, 10) : (int)$longitude;
        } else {
            $longitude = str_replace(".", "", $data['longitude']);

            $longitudes = (strlen($longitude) > 10) ? (int)substr($longitude, 0, 9) : (int)$longitude;
        }

        $location = [
            'address' => $input['address'],
            'latitude' => $latitudes,
            'longitude' => $longitudes,
            'postal_code' => $input['postal_code'],
            'city_id' => $cities_data->id,
            'state_id' => $cities_data->state_id,
            'country_id' => $cities_data->country_id
        ];
        $loc = Location::create($location);

        $updateRecord = [
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone' => phoneFormat($input['phone']),
            'email' => $input['email'],
            'location_id' => $loc->id
        ];
        if ($request->hasfile('profile_image')) {

            $file = $request->file('profile_image');
            $fileName = $file->getClientOriginalName();
            $file->move(backendUserFile(), $file->getClientOriginalName());
            $updateRecord['image'] = url(backendUserFile() . $file->getClientOriginalName());
        }

        $this->userRepository->update(auth()->user()->id, $updateRecord);
        return Redirect::to('vehicle-information');
    }


    /**
     * Joey Vehicle Information view
     *
     */
    public function vehicleInformation()
    {
        $status = [
            'personal' => 3,
            'vehicle' => 1,
            'work' => 2,
            'additional' => 2
        ];
        $record = $this->userRepository->find(auth()->user()->id);
        return view('front.signup-step2', compact('status', 'record'));
    }

    /**
     * Joey Vehicle Information Create
     *
     */
    public function vehicleInformationCreate(VehicleInformationRequest $request)
    {
        $input = $request->all();

        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );
        $vehicle = JoeyVehicle::where('joey_id', auth()->user()->id)->first();
        $vehicleRecord = [
            'joey_id' => auth()->user()->id,
            'vehicle_id' => $input['vehicleType'],
            'license_plate' => $input['license_plate'],
            'color' => $input['color'],
            'model' => $input['model'],
            'make' => $input['make'],
        ];
        if ($vehicle) {
            $vehicle->update($vehicleRecord);
        } else {
            JoeyVehicle::create($vehicleRecord);
        }
        return Redirect::to('work-preferences');
    }

    /**
     * Joey Work Preferences view
     *
     */
    public function workPreferences()
    {
        $status = [
            'personal' => 3,
            'vehicle' => 3,
            'work' => 1,
            'additional' => 2
        ];
        $zones = Zones::where('deleted_at', null)->orderBy('name')->get();
        $workTypes = PreferWorkType::where('deleted_at', null)->get();
        $workTimes = PreferWorkTime::where('deleted_at', null)->get();
        $record = $this->userRepository->find(auth()->user()->id);
        return view('front.signup-step3', compact('status', 'record', 'zones', 'workTypes', 'workTimes'));
    }

    /**
     * Joey  Work Preferences Create
     *
     */
    public function workPreferencesCreate(WorkPreferencesRequest $request)
    {
        $input = $request->all();

        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );
        $createRecord = [
            'work_type' => $data['shiftStoreType'],
            'contact_time' => $data['work_time'],
            'preferred_zone_id' => $data['preferred_zone'],
        ];

        $this->userRepository->update(auth()->user()->id, $createRecord);
        return Redirect::to('additional-information');
    }


    /**
     * Joey Additional Information view
     *
     */
    public function additionalInformation()
    {
        $status = [
            'personal' => 3,
            'vehicle' => 3,
            'work' => 3,
            'additional' => 1
        ];

        $record = $this->userRepository->find(auth()->user()->id);
        return view('front.signup-step4', compact('status', 'record'));
    }

    /**
     * Joey   Additional Information Create
     *
     */
    public function additionalInformationCreate(AdditionalInformationRequest $request)
    {
        $input = $request->all();
        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );

        $joey = $this->userRepository->find(auth()->user()->id);


        $recordForJoeyDeposit = [
            'joey_id' => $joey->id,
            'institution_no' => $data['institution_no'],
            'branch_no' => $data['branch_no'],
            'account_no' => $data['account_no'],
        ];
        $recordForUserTable = [
            'hst_number' => $data['hst_number'],
            'is_active' => 1
        ];


        $recordCheck = JoeyDeposit::where('joey_id', $joey->id)->first();

        if (!empty($recordCheck)) {

            JoeyDeposit::where('joey_id', $joey->id)->update($recordForJoeyDeposit);
        } else {
            JoeyDeposit::create($recordForJoeyDeposit);
        }

        $this->userRepository->update(auth()->user()->id, $recordForUserTable);

        return Redirect::to('application-success');
    }

    /**
     * Joey Application Success view
     *
     */
    public function applicationSuccess()
    {
        return view('front.application-success');
    }

    /**
     * Joey Profile Edit view
     *
     */
    public function showProfileForm()
    {

        $notification = DB::table('metadata')->where('object_type', 'joeys')->where('object_id', auth()->user()->id)->first();
        $upcomingShift = ZoneSchedule::join('joeys_zone_schedule', 'joeys_zone_schedule.zone_schedule_id', '=', 'zone_schedule.id')
            ->where('joeys_zone_schedule.joey_id', '=', auth()->user()->id)
            ->where('is_display', '=', 1)
            ->whereNull('joeys_zone_schedule.deleted_at')
            ->whereNull('zone_schedule.deleted_at')
            ->where('zone_schedule.start_time', '>=', date('Y-m-d H:i:s'))
            ->orderBy('zone_schedule.start_time', 'ASC')->get(['zone_schedule.*']);
        return view('front.account', compact('notification', 'upcomingShift'));
    }

    /**
     * Joey Profile Edit view
     *
     */
    public function updateProfile(UpdateJoeyRequest $request)
    {
        $input = $request->all();

        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );

        $location = [
            'address' => $input['Address'],
            'suite' => $input['Apt'],
            'postal_code' => $input['code'],
        ];
        $loc = Location::create($location);

        $updateRecord = [
            'display_name' => $input['displayNameAs'],
            'nickname' => $input['nickname'],
            'phone' => phoneFormat($input['phoneNumber']),
            'about' => $input['overview'],
            'shift_store_type' => $input['shiftStoreType'],
            'location_id' => $loc->id
        ];

        if ($request->hasfile('profile_image')) {

            $file = $request->file('profile_image');
            $fileName = $file->getClientOriginalName();
            $file->move(backendUserFile(), $file->getClientOriginalName());
            $updateRecord['image'] = url(backendUserFile() . $file->getClientOriginalName());
        }

        $this->userRepository->update(auth()->user()->id, $updateRecord);

        $deposit = JoeyDeposit::where('joey_id', auth()->user()->id)->first();
        $depositeRecord = [
            'joey_id' => auth()->user()->id,
            'institution_no' => $input['institutionNumber'],
            'branch_no' => $input['branchNumber'],
            'account_no' => $input['accountNumber'],
        ];
        if ($deposit) {
            $deposit->update($depositeRecord);
        } else {
            JoeyDeposit::create($depositeRecord);
        }

        $vehicle = JoeyVehicle::where('joey_id', auth()->user()->id)->first();
        $vehicleRecord = [
            'joey_id' => auth()->user()->id,
            'vehicle_id' => $input['vehicleType'],
            'license_plate' => $input['license'],
            'color' => $input['color'],
            'model' => $input['model'],
            'make' => $input['make'],
        ];
        if ($vehicle) {
            $vehicle->update($vehicleRecord);
        } else {
            JoeyVehicle::create($vehicleRecord);
        }

        $notification = JoeyMetaData::where('object_type', 'joeys')->where('object_id', auth()->user()->id)->first();
        $notificationRecord = [
            'object_type' => 'joeys',
            'object_id' => auth()->user()->id,
            'key' => 'prefs-notification-type',
            'value' => $input['notificationType'],

        ];

        if ($notification) {
            $notification->update($notificationRecord);
        } else {
            JoeyMetaData::create($notificationRecord);
        }

        return Redirect::to('profile')->with('message', 'your profile has been update successfully ');
    }

    /**
     * Joey NewsLetter Update
     *
     */
    public function newsletterUpdate(Request $request)
    {
        $input = $request->all();

        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );
        $joey = User::where('id', auth()->user()->id)->first();
        if ($joey->is_newsletter == 0) {
            $updateRecord['is_newsletter'] = 1;
        } else {
            $updateRecord['is_newsletter'] = 0;
        }
        $this->userRepository->update(auth()->user()->id, $updateRecord);

        return 1;
    }

}
