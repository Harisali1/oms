<?php

namespace App\Http\Controllers\Front\Auth;

use App\Events\JoeyCreateEvent;
use App\Http\Requests\Front\StoreJoeyRequest;
use App\Models\City;
use App\Models\JoeyVehicle;
use App\Models\Location;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

use App\Http\Controllers\Controller;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    private $userRepository;

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('guest:web');
        parent::__construct();
        $this->userRepository = $userRepository;
    }


    /**
     * Update Auth Guard
     *
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Show Signup view
     *
     */
    public function showSignUpView(Request $request)
    {
        return view('front.signup');
    }


    /**
     * sign up Step One call
     *
     */
    public function registerJoey(StoreJoeyRequest $request)
    {

        $data = $request->all();
        $token = uniqid(rand(1,20), true);
        $createRecord = [
            'first_name' =>  $data['first_name'],
            'last_name' =>  $data['last_name'],
            'phone' =>  $data['phone'],
            'email' =>  $data['email'],
            'password' => Hash::make($data['password']),
            'is_enabled' => 1,
            'user_type' => 'joey',
            'email_verify_token'=>$token,
            'location_id' => 1,
        ];

        $joey  = $this->userRepository->create($createRecord);

        event(new JoeyCreateEvent($joey));

        return Redirect::to('signup')->with('message',  'Your account has been register successfully, Please activate your account');
    }

    /**
     * Account being active
     */
    public function accountActive($email,$token){


        $email=base64_decode($email);
        User::where('email',$email)->where('email_verify_token',$token)->update(['email_verify_token'=>null]);
        return redirect()->guest('account/active/success');
    }


    /**
     * Account being active success
     */
    public function accountActiveSuccess(){

        return Redirect::to('login')->with('message',  'Your account has been activate successfully, Please login your account');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(StoreJoeyRequest $request)
    {
        $input = $request->all();

        $data = $request->except(
            [
                '_token',
                '_method',
            ]
        );

        $city = $input['city'];
        //Check city exist or not
        $cities_data = City::where('name', $city)->first();
        if (empty($cities_data) || $city == ''  || $city == null) {
            return response()->json(['status' => false, 'message' => 'Wrong address please enter correct address']);
        }

        //check condition for actual longitude
        $lng = strlen((int)$data['longitude']);

        $latitude = str_replace(".", "", $data['latitude']);
        $latitudes = (strlen($latitude) > 10) ? (int)substr($latitude, 0, 9) : (int)$latitude;
        if ($lng == 4){
            $longitude = str_replace(".", "", $data['longitude']);
            $longitudes = (strlen($longitude) > 10) ? (int)substr($longitude, 0, 10) : (int)$longitude;
        }
        else{
            $longitude = str_replace(".", "", $data['longitude']);

            $longitudes = (strlen($longitude) > 10) ? (int)substr($longitude, 0, 9) : (int)$longitude;
        }

        $location = [
            'address' => $input['address'],
            'suite' =>  $input['UnitNumber'],
            'latitude' => $latitudes,
            'longitude' => $longitudes,
            'postal_code' => $input['postal'],
            'city_id' => $cities_data->id,
            'state_id' => $cities_data->state_id,
            'country_id' => $cities_data->country_id
        ];
        $loc = Location::create($location);

        $createRecord = [
            'first_name' =>  $input['firstName'],
            'last_name' =>  $input['lastName'],
            'phone' =>  phoneFormat($input['phone']),
            'email' =>  $input['email'],
            'password' => Hash::make($input['password']),
            'location_id' => $loc->id,
            'preferred_zone' => $input['preferred_zone'],
            'hear_from' => strval((implode(',', $input['hearAboutUs']))),
            'work_type_id' =>1,// $input['work_type'],
            'contact_time_id' =>1,// $input['contact_time'],
            'image' => url(backendUserFile() . 'joey_profile.jpg')

        ];
        if (isset($input['newsletter_agree'])){
            $createRecord['is_newsletter'] = 1;
        }
        else{
            $createRecord['is_newsletter'] = 0;
        }

        $joey  = $this->userRepository->create($createRecord);

        //dd($createRecord);
        $vehicleRecord = [
            'joey_id' => $joey->id,
            'vehicle_id' => $input['vehicle'],
            'license_plate' =>  '',
            'color' =>  '',
            'model' =>  '',
            'make' =>  '',
        ];

         JoeyVehicle::create($vehicleRecord);

        return Redirect::to('login')->with('message',  'Your account has been created successfully');
    }




}
