<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\ProfileUpdateRequest;
use App\Http\Requests\Front\UpdatePasswordRequest;
use App\Models\Hub;
use App\Models\Joey;
use App\Models\JoeyRoutes;
use App\Models\Sprint;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Vendor;
use App\Models\Zones;
use App\Models\ZoneSchedule;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    private $adminRepository; // Private function only use to in this class only

    /**
     * Create a new controller instance.
     * @param UserRepositoryInterface $adminRepository
     */

    public function __construct(UserRepositoryInterface $adminRepository)
    {
        $this->middleware('auth:web');
        parent::__construct();
        $this->adminRepository = $adminRepository;
    }

    /**
     * Dispatch Sign-up Success view
     */
    public function signUpSuccess()
    {
        //Getting vendors count with limit
        $vendors = Vendor::limit(10)->get();
        //Getting on duty joeys
        $joeys = Joey::where('on_duty', '=', 1)->limit(10)->get();
        //Check for today date
        $date = new \DateTime();
        $start_date = $date->format('Y-m-d').' 00:00:00';
        $end_date = $date->format('Y-m-d').' 23:59:59';
        $year = ['2016', '2017', '2018', '2019', '2020', '2021'];
        $user = [];
        foreach ($year as $key => $value) {
            $user[] = Vendor::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"), $value)->count();
        }
        $year = json_encode($year, JSON_NUMERIC_CHECK);
        $user = json_encode($user, JSON_NUMERIC_CHECK);
        $ecommerceOrdersCount = Sprint::whereIn('creator_id',[477260,477282,477340,477341,477342,477343,477344,477345,477346,475874,477255,477254,477283,477284,477286,477287,477288,477289,477307,477308,477309,477310,477311,477312,477313,
        477314,477292,477294,477315,477317,477316,477295,477302,477303,477304,477305,477306,477296,477290,477297,477298,477299,477300,
        477320,477301,477318,477328,476294,477334,477335,477336,477337,477338,477339])
        ->whereBetween('created_at', [$start_date, $end_date])
        ->count(['id']);

        $groceryOrdersCount = Sprint::whereIn('creator_id',[475761,476610,476734,476850,476867,476933,476967,476968,476969,476970,477006,477068,477069,477078,477123,477124,477133,477150,477153,477154,477157,477192,477209,477233,
        477234,477235,477236,477237,477238,477239,477240,477241,477242,477244,477245,477246,477247,477248,477249,477250,477251,477252,477253,477267,477268,477271,477272,477273,477279,
        477285,477348,477349,477350,477351,477352,477353,477354,477355,477356,477357,477358,477359,477360,477361,477362,477363,477364,477365,477366,477367,477368,477369,477370,477371,
        477372,477373,477374,477375,477376,477377,477378,477379,477380,477381,477382,477383,477384,477385,477386,477387,477388,477389,477390,477391,477392,477393,477394,477395,477396,
        477397,477398,477399,477400,477401,477402,477403,477404,477405,477406,477407,477408,477409,477410,477411,477412,477413,477414,477415,477416,477417,477418,477419,477420,477421,
        477422,477423,477424,477425,477426,477438,477439,477451,477452,477454,477503,477281,477466,477467,477468,477469,477470,477194,477195,477205,477464,477465,477471,477472,477473,477474,477475,477164])
        ->whereBetween('created_at', [$start_date, $end_date])
        ->count(['id']);

        return view('front.dashboards.dashboard',
            compact(
                'vendors',
                'joeys',
                'year',
                'user',
                'ecommerceOrdersCount',
                'groceryOrdersCount'
            ));


    }

    /**
     * Update Profile View
     *
     */
    public function updateProfileView()
    {

        $data = $this->adminRepository->find(auth()->user()->id);
        return view('front.profile.edit-profile', compact('data'));

    }

    /**
     * Update Profile
     * @param ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEditProfile(ProfileUpdateRequest $request)
    {

        $userRecord = auth()->user();
        $exceptFields = [
            '_token',
            '_method',
            'email',
        ];

        // 1 = super admin user id, and is_active status cannot be set for it
        if ($userRecord->id == 1) {
            $exceptFields[] = 'is_active';
        }
        $data = $request->except($exceptFields);

        $updateRecord = [
            'name' => $data['name'],
            'phone' => phoneFormat($data['phone']),
        ];

        //check logo if exists
        if ($request->hasfile('profile_picture')) {


            //move | upload file on server
            $slug = Str::slug($data['name'], '-');
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $slug . '-' . time() . '.' . $extension;

            $file->move(backendUserFile(), $filename);

            $updateRecord['profile_picture'] = url(backendUserFile(), $filename);
            $oldImage = $userRecord->profile_picture;

        }
        if (isset($data['password'])) {
            $updateRecord['password'] = bcrypt($data['password']);
        }
        $this->adminRepository->update($userRecord->id, $updateRecord);

//        if (isset($oldImage)) {
//
//            $this->safeRemoveImage($oldImage, backendUserFile());
//
//        }
        /*return data */
        return redirect()
            ->route('edit-profile')
            ->with('success', 'Profile updated successfully.');
    }


    /**
     * Password Reset View
     *
     */
    public function resetPasswordView()
    {
        return view('front.profile.reset-password');

    }

    public function processChangePassword(UpdatePasswordRequest $request)
    {
        $id = Auth::user()->id;
        if (Hash::check($request->get('oldPassword'), Auth::user()->password)) {
            $data['password'] = bcrypt($request->get('password'));
            $this->adminRepository->update($id, $data);
            return redirect()
                ->route('users.change-password')
                ->with('success', 'Password has been changed successfully.');
        } else {
            return redirect()
                ->route('users.change-password')
                ->with('errors', 'Please enter the old password correctly.');
        }

    }
}
