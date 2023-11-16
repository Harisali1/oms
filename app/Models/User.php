<?php

namespace App\Models;

use App\Http\Traits\Metable\Metable;
use App\Mail\WelcomeMail;
use App\Models\Interfaces\UserInterface;
use App\Notifications\Backend\AdminResetPasswordNotification;
use Carbon\Carbon;
use DB;
use http\Url;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable implements UserInterface, JWTSubject
{

    public $table = 'admin_users';

    use SoftDeletes,Notifiable;
    public $timestamps = false;
    public const ROLE_ID = '2';
    public const ROLE_TYPE = '1';
    public const ACTIVE = 1;

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Meta table for this model.
     *
     * @var string
     */
    //protected $metaTable = 'user_meta';

    /**
     * Meta data model relating to this model.
     *
     * @var string
     */
   // protected $metaModel = UserMeta::class;

   //public function metas()
   //{
   //    return $this->hasMany(UserMeta::class, 'user_id');
   //}

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotAdmin($query)
    {
        $admin_role_id =  config('app.super_admin_role_id');
        return $query->where('role_id', '!=',$admin_role_id);
    }

    public function isAdmin() {
        return (bool) (intval($this->attributes['role_id']) === self::ROLE_ADMIN);
    }

    public function IsUserActive()
    {
        return  ($this->status == self::ACTIVE) ? true : false ;
    }

    /**
     * User Related Method
     */
    public function validateUserActiveCriteria() : bool
    {
        if((int)$this->attributes['is_active'] === 0){

            if((int)$this->attributes['is_unblock'] === 0){
                //throw new \Mockery\Exception('Your account has been blocked by the admin, please contact '. constants('global.site.name').' admin');
                throw new \App\Exceptions\UserNotAllowedToLogin('Your account has been blocked by the admin, please contact ', 'account_block');
            }
            if((int)$this->attributes['is_verified'] === 0){
                //throw new \Mockery\Exception('Your account has not been verify by the admin, please contact '. constants('global.site.name').' admin');
                throw new \App\Exceptions\UserNotAllowedToLogin('Your account has not been verify by the admin, please contact ', 'account_verify');
            }

            if((int)$this->attributes['email_verified'] !== 1){
                //throw new \Mockery\Exception('Your email is not verified please verify your email first.');
                throw new \App\Exceptions\UserNotAllowedToLogin('Your email is not verified please verify your email first.', 'account_email_verify');
            }

            if((int)$this->attributes['sms_verified'] !== 1){
                //throw new \Mockery\Exception('Please verify your mobile number first, it\'s not verified.');
                throw new \App\Exceptions\UserNotAllowedToLogin('Please verify your mobile number first, it\'s not verified.', 'account_sms_verify');
            }

            //throw new \Mockery\Exception('Your account is inactive, please contact '. constants('global.site.name').' admin');
            throw new \App\Exceptions\UserNotAllowedToLogin('Your account is inactive, please contact '. constants('global.site.name').' admin', 'account_active');
        }

        return true;

    }

    /**
     * Customer Deactivate
     */
    public function deactivate() : void
    {
        $this->status  = 0;
        $this->save();
    }

    /**
     * Customer Activate
     */
    public function activate() : void
    {
        $this->status  = 1;
        $this->save();
    }

    /**
     * Set Status text Format
     */
    public function getStatusTextFormattedAttribute() : string
    {
        return (int)$this->attributes['status'] === 1 ?
            '<a href="'. route('sub-admin.inactive', $this->attributes['id']) .'"><span class="label label-success">Active</span></a>' :
            '<a href="'. route('sub-admin.active', $this->attributes['id']) .'"><span class="label label-warning">Inactive</span></a>';
    }

    /**
     * Send Reset Password Email
     */
    public function sendPasswordResetEmail($email,$token,$role_id)
    {
        $this->notify(new AdminResetPasswordNotification($email,$token,$role_id));
    }

    /**
     * Get Phone format
     */
    /*public function getPhoneFormattedAttribute()
    {
        return $this->attributes['phone'] ? phone($this->attributes['phone'])->formatNational() : '';// $this->attributes['phone'] : '';
    }*/

    /**
     * Get current permissions user.
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->Permissions->pluck('route_name')->toArray();
    }

    /**
     * Get the role of user.
     *
     * @return array
     */
    public function Role()
    {

        return $this->belongsTo(Roles::class, 'role_id','id');
    }

    /**
     * Get the role of user.
     *
     * @return array
     */
    public function DashboardCardRightsArray()
    {
        $rights = false;
        $data = $this->Role()->pluck('dashbaord_cards_rights')->first();

        if($this->role_type == Permissions::GetSuperAdminRole())
        {
            return true;
        }

        if($data != null && $data != '')
        {
            $rights = explode(',',$data);

        }

        return $rights;

    }

    /**
     * Get the role permissions .
     *
     * @return array
     */
    public function Permissions()
    {
        return $this->hasMany(Permissions::class, 'role_id','role_id');
    }

    public function getFullname()
    {

        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get permissions data extracted .
     *
     * @return array
     */
    public function PermissionsExtract()
    {
        return $this->hasMany(Permissions::class, 'role_id','role_id')->pluck('route_name')->toArray();
    }

    public  function sendWelcomeEmail()
 {
     $email = $this->attributes['email'];
     $name = $this->attributes['name'];
     $token = uniqid(Str::random(64),true);

 /*    DB::table(config('auth.passwords.users.table'))->insert([
         'email' => $email,
         'token' => $token,
         'created_at' => Carbon::now()
     ]);*/
     DB::table('password_resets')->insert([
         'email' => $email,
         'token' => $token,
         'created_at' => Carbon::now()
     ]);

     $resetUrl = url('/reset-password?email='.$email.'&token='.$token.'');

     return  $this->notify(new \App\Notifications\Backend\ResetPasswordEmailSend($resetUrl,$name));

 }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function checkProfile()
    {
        $signupProcess= [
            'document'=>0,
            'quiz'=>0,
            'joey'=>0
        ];
        $documentTypes = DocumentType::whereNull('deleted_at')->where('is_optional',1)->pluck('id')->toArray();
        $documents = JoeyDocument::where('joey_id', '=', $this->id)->whereIn('document_type_id',$documentTypes)->pluck('document_type_id')->toArray();
        if (count($documents) >= count($documentTypes))
        {
            $signupProcess['document'] = 1;
        }
        $category = OrderCategory::where('type','basic')->pluck('id')->toArray();
        $quizCheck = JoeyAttemptedQuiz::where('joey_id', '=', $this->id)->whereIn('category_id',$category)->where('is_passed',1)->pluck('id')->toArray();
        if (count($quizCheck) >= count($category))
        {
            $signupProcess['quiz'] = 1;
        }
        $joey_agreement = JoeyAgreement::where('user_id',$this->id)->where('user_type','joeys')->orderBy('id','desc')->first();
        if (!empty($joey_agreement)){
            $signupProcess['joey'] = 1;
        }
        return $signupProcess;
    }

    public function sendSubadminPasswordResetEmail($email, $name, $token, $role_id)
    {
        $bg_img = 'background-image:url(' . asset('assets/admin/joeyco_icon.png') . ');';
        $bg_img = trim($bg_img);
        $style = "font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color: black !important;";
        $style1 = "font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';";
        $body = '<div class="row" style=" width: 32%;margin: 0 AUTO;">
                <div style="text-align: center;
    background-color: lightgrey;"><img src="' . url('/') . '/assets/admin/logo.png" alt="Web Builder" class="img-responsive" style="margin:0 auto; width:150px;" /></div>
                <div style="' . $bg_img . '
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;">
                  <h1 style="'.$style.'">Hi, ' . $name . '!</h1>

                <p style="'.$style.'">You are receiving this email because Joeyco Dashboard Admin has created your account for using Joeyco Dashboard, kindly reset your password and login to your account.</p>
                <div style="text-align: center;'.$style.'"><a class="btn btn-link" href=' . route('password.reset', [$email, $token, $role_id]) . ' class="btn btn-primary" ><button style="padding: 10px;background-color: #E36D28;border: 0px;border-radius: 6px;">Reset Password</button></a></div>
                 <p style="'.$style.'">If you did not request for account, no further action is required.</p>

                 <br/>
                 <p style="'.$style.'"> If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
                <a style="word-break: break-all;'.$style1.'" href=' . route('password.reset', [$email, $token, $role_id]) . ' > '.route("password.reset", [$email, $token, $role_id]). '</a></p>
                 <br/>
                 <br/>

                </div>
                 <div style="background-color: lightgrey;padding: 5px;">
        <p style="padding-bottom: -1px;margin: 0px;margin-left: 20px;'.$style.'">JoeyCo Inc.</p>
        <p style="margin-top: 0x;margin: 0px;margin-left: 20px;'.$style.'">16 Four Seasons Pl., Etobicoke, ON M9B 6E5</p>
        <p style="margin: 0px;margin-left: 20px;'.$style.'">+1 (855) 556-3926 · support@joeyco.com </p>
    </div>
                </div>
                ';
        $subject = "Reset Password Link";
        $email = base64_decode($email);
        Mail::send(array(), array(), function ($m) use ($email, $subject, $body) {
            $m->to($email)
                ->subject($subject)
                ->from(env('MAIL_USERNAME'))
                ->setBody($body, 'text/html');
        });
    }


    public function sendWelcomeEmail2($randomid)
    {
        $email = $this->attributes['email'];
        $full_name = $this->attributes['name'];
        $style = "font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color: black !important;";
        $bg_img = 'background-image:url(' . url("/images/joeyco_icon_water.png") . ');';
        $bg_img = trim($bg_img);
        $body = '<div class="row" style=" width: 32%;margin: 0 AUTO;">
                <div style="text-align: center;
    background-color: lightgrey;"><img src="' . url('/') . '/images/abc.png" alt="Web Builder" class="img-responsive" style="margin:0 auto; width:150px;" /></div>
                <div style="' . $bg_img . '
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;">
                  <h1 style="'.$style.'">Hi, ' . $full_name . '!</h1>

                 <p style="'.$style.'">You are receiving this email because we received a Two-factor authentication request for your account.</p>
                <p style="'.$style.'">Your Two-factor authentication code is <span style="background-color: #E36D28;border: 0px;">' . $randomid . '</span></p>
				<br/>
                 <p style="'.$style.'">If you did not request a Two-factor authentication, no further action is required.</p>
                  <br/>


                </div>
                <div style="background-color: lightgrey;padding: 5px;">
        <p style="padding-bottom: -1px;margin: 0px;margin-left: 20px;'.$style.'">JoeyCo Inc.</p>
        <p style="margin-top: 0x;margin: 0px;margin-left: 20px;'.$style.'">16 Four Seasons Pl., Etobicoke, ON M9B 6E5</p>
        <p style="margin: 0px;margin-left: 20px;'.$style.'">+1 (855) 556-3926 · support@joeyco.com </p>
    </div>
                </div>
                ';
        $subject = "Your 6 digit code for Authentication";
        Mail::send(array(), array(), function ($m) use ($email, $subject, $body) {
            $m->to($email)
                ->subject($subject)
                ->from(env('MAIL_USERNAME'))
                ->setBody($body, 'text/html');
        });
    }
}
