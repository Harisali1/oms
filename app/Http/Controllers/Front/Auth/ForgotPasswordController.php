<?php

namespace App\Http\Controllers\Front\Auth;


use App\Http\Controllers\Front\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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

    public function broker()
    {
        return Password::broker('users');
    }

    /**
     * Show Forgot Password View
     *
     */
    public function showLinkRequestForm()
    {

        return view('front.auth.passwords.email');
    }


    /**
     * Show custom reset password form
     */
    public function send_reset_link_email(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return Redirect::to('password/reset')->withErrors('Email not exist. try again!.');
        }
        $token_validate = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('role_id', $request->role_id)
            ->first();
        $token = hash('ripemd160',uniqid(rand(),true));
        if ($token_validate == null) {
            DB::table('password_resets')
                ->insert(['email'=> $request->email,'role_id' =>  $request->role_id,'token' => $token]);
        }
        else
        {
            DB::table('password_resets')
                ->where('email', $request->email)
                ->where('role_id', $request->role_id)->update(['token' => $token]);
        }

        $email = base64_encode ($request->email);
        $user->sendSubadminPasswordResetEmail($email,$user->name,$token,$request->role_id);
        return Redirect::to('password/reset')->with('message',  'We have sent your password reset link on email, Please also check Junk/Spam folder as well!');
    }
}
