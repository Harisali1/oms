<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\StoreSubAdminRequest;
use App\Http\Requests\Front\UpdateSubAdminRequest;
use App\Models\Roles;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubAdminController extends Controller
{
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth:web');
//        dd($userRepository);
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Sub-Admin View
     *
     */
    public function index()
    {
        $sub_admins =  User::where('id','!=',auth()->user()->id)->orderBy('id','DESC')->paginate(10);
        return view('front.sub-admin.subadmins',compact('sub_admins'));

    }

    /**
     * Active
     *
     */
    public function active(User $record)
    {
        $record->activate();
        return redirect()
            ->route('sub-admin.index')
            ->with('success', 'Sub admin has been active successfully!');
    }

    /**
     * In Active
     *
     */
    public function inactive(User $record)
    {
        $record->deactivate();
        return redirect()
            ->route('sub-admin.index')
            ->with('success', 'Sub admin has been In active successfully!');
    }

    /**
     * Sub-Admin Create View
     *
     */
    public function create()
    {
        $role_list  = Roles::NotAdminRole()->get();
        return view('front.sub-admin.add-subadmin',compact('role_list'));

    }

    /**
     * Store Sub-Admin Function
     * @param StoreSubAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSubAdminRequest $request)
    {
        $data = $request->all();

        $createRecord = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => \Hash::make($data['password']),
            'role_id' =>$data['role_id'],
            'role_type' =>2,
            'status' => 1,

        ];
        //$file = $request->file('upload_file');
        if ($request->hasfile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = $file->getClientOriginalName();
            $file->move(backendUserFile(), $file->getClientOriginalName());

            $data['profile_picture'] = $fileName;
            $createRecord['profile_picture'] = url(backendUserFile() . $file->getClientOriginalName());

        }
        else{
            $createRecord['profile_picture'] = url(backendUserFile() . 'default.jpg');
        }



        $user =$this->userRepository->create($createRecord);

        $token = hash('ripemd160',uniqid(rand(),true));
        DB::table('password_resets')
            ->insert(['email'=> $data['email'],'role_id' =>  User::ROLE_ID,'token' => $token]);

        $email = base64_encode ($data['email']);
        $user->sendSubadminPasswordResetEmail($email,$data['name'],$token,User::ROLE_ID);

        return redirect()
            ->route('sub-admin.index')
            ->with('success', 'Sub admin added successfully.');

    }

    /**
     * Sub-Admin Create View
     *
     */
    public function edit($subadmin)
    {
        $id=base64_decode ($subadmin);
        //Find user by id
        $sub_admin = User ::find($id);

        //Getting roles
        $role_list  = Roles::NotAdminRole()->get();

        return view('front.sub-admin.edit-subadmin',compact('role_list','sub_admin'));
    }

    public function update(UpdateSubAdminRequest $request, User $sub_admin)
    {
        $data = $request->all();
        $updateRecord = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role_id' =>$data['role'],

        ];
        if ($request->hasfile('upload_file')) {
            $file = $request->file('upload_file');
            $fileName = $file->getClientOriginalName();
            $file->move(backendUserFile(), $file->getClientOriginalName());
            $updateRecord['profile_picture'] =  url(backendUserFile() .$fileName);

        }

        if ( $request->has('password') && $request->get('password', '') != '' ) {
            $updateRecord['password'] = \Hash::make( $data['password'] );
        }

        $this->userRepository->update($sub_admin->id, $updateRecord);
        return redirect()
            ->route('sub-admin.index')
            ->with('success', 'Sub admin updated successfully.');
    }

    /**
     * Removes the resource from database.
     */
    public function destroy(User $sub_admin)
    {
        $this->userRepository->delete($sub_admin->id);
        return redirect()
            ->route('sub-admin.index')
            ->with('success', 'Sub admin has been removed successfully.');
    }

}
