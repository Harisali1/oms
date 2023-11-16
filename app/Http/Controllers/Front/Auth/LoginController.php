<?php

namespace App\Http\Controllers\Front\Auth;

use App\Classes\Google\GoogleAuthenticator;
use App\Http\Controllers\Front\Controller;
use App\Http\Requests\Front\GoogleAuthRequest;
use App\Models\DashboardLoginIp;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
 |--------------------------------------------------------------------------
 | Login Controller
 |--------------------------------------------------------------------------
 |
 | This controller handles authenticating users for the application and
 | redirecting them to your home screen. The controller uses a trait
 | to conveniently provide its functionality to your applications.
 |
 */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /*
         * Logged in user should not be able to visit login page, unless logged out
         *
         * It's redirection is managed from App > Http > Middleware > RedirectIfAuthenticated
         */
        $this->middleware('guest:web')->except('logout');
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
     * Show Login view
     *
     */
    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    /**
     * Login call
     *
     */
//    public function login(Request $request)
//    {
//        $user_check = User::where('email', $request->get('email'))->first();
////check for password
//        $passCheck = Hash::check(request('password'), $user_check->password);
//        if(!$passCheck){
//            return Redirect::to('login')
//                ->withErrors('Password is Incorrect');
//        }
//
//
//        if (!$user_check) {
//
//            return Redirect::to('login')
//                ->withErrors('These credentials do not match our records.');
//        }
//
////        if($user_check->status == 0){
////            return Redirect::to('login')
////                ->withErrors('Your account has been temporary in active.');
////        }
//        if (!empty($user_check->email_verify_token)) {
//            return Redirect::to('login')
//                ->withErrors('Your account not been activate, Please check your inbox/spam');
//        }
//
//        $this->validateLogin($request);
//
//
////dd($this->attemptLogin($request));
////        if (!is_null($user_check) && $user_check->is_email != 0 || $user_check->is_scan != 0) {
//            if ($this->attemptLogin($request)) {
//                return $this->sendLoginResponse($request);
//            }
////        } else {
////            $passwordencode = base64_encode($request->get('password'));
////            $id = base64_encode($user_check->id);
////            $mail = $user_check->is_email;
////            $scan = $user_check->is_scan;
////            return redirect('auth-type?id=' . $id . '&key=' . $passwordencode . '&mail=' . $mail . '&scan=' . $scan);
////        }
//
//
////        if ($this->attemptLogin($request)) {
////            return $this->sendLoginResponse($request);
////        }
//
//        return $this->sendFailedLoginResponse($request);
//    }

    public function login(Request $request)
    {
//        dd($request->all());
        $this->validateLogin($request);


        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function getType(Request $request)
    {
        return view('front.auth.authentication.type', $request->all());
    }


    public function posttypeauth(Request $request)
    {
        $data=$request->all();
//        dd($request->all());
        if(strcmp("Scan",$data['type'])==0){
//            dd('hello');
            return redirect('google-auth?id=' . $data['id'] . "&key=" . $data['key']);
        }
        else{
//            dd('what hello');

            $randomid = mt_rand(100000,999999);

            $admin = User::where('id','=', base64_decode($data['id']))->first();
            $admin['emailauthanticationcode'] = $randomid;

            $admin->save();

            //\JoeyCo\Tools\PHPMail::send("JOEYCO",$admin->attributes['email'], "Your 6 digit code for Authentication", "Your code is ".$randomid);
            $admin->sendWelcomeEmail2($randomid);

            $data['email'] = base64_encode($admin['email']);

            return redirect('verify-code?key=' . $data['key'] . '&email=' . $data['email']);

        }
    }

    public function getverifycode(Request $request){

        return view('front.auth.authentication.verificationcode', $request->all());
    }

    public function getgoogleAuth(Request $request){

        $admin = User::where('id', '=', base64_decode($request->get('id')))->first();
        $authenticator = new GoogleAuthenticator();

        if( empty($admin['googlecode']) ){

            $admin['googlecode'] = $authenticator->createSecret();
            $admin->save();
        }

        $adminLoginIpTrusted = DashboardLoginIp::where( 'dashboard_user_id','=', $admin['id'] )->whereNull('deleted_at')->first();

        if( is_null($adminLoginIpTrusted) ){
            $qrUrl =  $authenticator->getQRCodeGoogleUrl($admin['email'], $admin['googlecode']);
        }else{
            $qrUrl = null;
        }

        $data = ['secret' => $admin['googlecode'], 'qrUrl' => $qrUrl, 'email' => $admin['email'], 'key' => $request->get('key') ];

        return view('front.auth.authentication.googleauth', $data );
    }

    public function postgoogleAuth(GoogleAuthRequest $request){


        $inputs = $request->all();

        $admin = User::where('email', '=', $request->get('email'))->first();

        $passworddecode = base64_decode($request->get('key'));
        $request['password'] = $passworddecode;

        $authenticator = new GoogleAuthenticator();


        if( !$authenticator->verifyCode( $request->get('secret'),  $request->get('code'))) {
            return redirect('google-auth?id=' . base64_encode($admin['id']) . "&key=" . $inputs['key'])->withErrors('Your Verification Code is not Valid!.');
        }
        else if (!Auth::attempt(['email'=>$request->get('email'),'password'=>$passworddecode,'status'=>'1']))
        {
            return redirect('login')->withErrors('Invalid Username or Password.');
        }
        else {
            if (isset($inputs['is_trusted'])) {
                $now = new \DateTime();

                DashboardLoginIp::where('dashboard_user_id', '=', $admin['id'])->where('ip', '=', $this->get_ipaddress())->delete();
                DashboardLoginIp::create(['dashboard_user_id' => $admin['id'], 'ip' => $this->get_ipaddress(), 'trusted_date' => $now->modify('+30 days')]);
            } else {

                DashboardLoginIp::create(['dashboard_user_id' => $admin['id'], 'ip' => $this->get_ipaddress()]);
            }
            return $this->login($request);
        }

    }

    public function postverifycode(Request $request){

//dd(base64_decode($request->get('email')));
        $code=$request->get('code');

        $data= User::where('email','=', base64_decode($request->get('email')))->where('emailauthanticationcode','=',$code)->first();

//        dd($data);
        $email = base64_decode($request->get('email'));
        $passworddecode = base64_decode($request->get('key'));

        $request['email'] = $email;
        $request['password'] = $passworddecode;

//        dd($request->all());

        $email = $request->get('email');
        $key = $request->get('key');
        if(empty($data)){
            return redirect('verify-code?key=' . $key . '&email=' . base64_encode($email))->withErrors('Invalid verification code!');
        }
        else if (!Auth::attempt(['email'=>$email,'password'=>$passworddecode,'status'=>'1']))
        {
            return redirect('login')->withErrors('Invalid Username or Password.');
        }
        return $this->login($request);
    }
    /**
     * Get Credential
     *
     */
    protected function credentials(Request $request)
    {
        // return $request->only($this->username(), 'password');
        return [
            'email' => $request->{$this->username()},
            'password' => $request->password,
            // 'remember' => true
            //  'role_id' => 2,
            // 'is_active' => 1
        ];
    }

    private function get_ipaddress() {
        $ipaddress = null;
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
    }

    /**
     * Logout
     *
     */
    public function logout(Request $request)
    {
        /*
         * Here, admin guard is being called by $this->guard()
         */
        $this->guard()->logout();

        // $request->session()->invalidate();

        return Redirect::to('login');
    }

    /**
     * Handle forgot password
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function forgotPassword(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('admin.auth.forgot-password');
    }
}
