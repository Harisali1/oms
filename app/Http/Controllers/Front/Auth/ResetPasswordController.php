<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Front\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Validator;
use Password;
use Auth;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Password Reset Controller
     |--------------------------------------------------------------------------
     |
     | This controller is responsible for handling password reset requests
     | and uses a simple trait to include this behavior. You're free to
     | explore this trait and override any methods you wish to tweak.
     |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web');
        parent::__construct();
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
     * Update Password Broker
     *
     */
    public function broker()
    {

        return Password::broker('users');
    }

    /**
     * show Reset View
     *
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    /**
     * Show custom reset password form
     */
    public function reset_password_from_show($email,$token,$role_id)
    {
        $email = base64_decode($email);

        if ($token == null || $email == null || $role_id == null) {
            return Redirect::to('password/reset');
        }
        $token_validate = DB::table('password_resets')
            ->where('token', $token)
            ->where('email', $email)
            ->where('role_id', $role_id)
            ->first();
        if ($token_validate == null) {
            return Redirect::to('password/reset');
        }
        return view('front.auth.passwords.custom-reset-password')->with(
            ['token' => $token_validate->token, 'email' => $token_validate->email, 'role_id' => $token_validate->role_id]
        );
    }

    /**
     * Update reset password
     */
    public function reset_password_update(Request $request)
    {

        $request->validate($this->rules());
        $password_reset_data = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('email', $request->email)
            ->where('role_id', $request->role_id)
            ->first();
        if ($password_reset_data == null) {
            return Redirect::to('password/reset');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);
//        DB::table('password_resets')
//            ->where('token', $request->token)
//            ->where('email', $request->email)
//            ->where('role_id', $request->role_id)
//            ->delete();
            return Redirect::to('login')
                ->with('message', 'Password reset successfully. Please enter your credentials and login');


    }
}
