<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'mobile' => 'required|unique:user,mobile',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user =  User::create([
                    'firstname' => $data['first_name'],
                    'lastname' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'mobile' => $data['mobile'],
                    'department_id' => 0,
                    'user_type' => 5,
                ]);

        $user = User::find($user->id);
        $user->company_id = $user->id;
        $user->save();


        $app = new \App\Models\Setting;
        $app->company_id = $user->id;
        $app->title   = 'Company Name';
        $app->description   = 'Type description here';
        $app->email   = $user->email;
        $app->copyright_text   = 'Copyright@'.date('Y');
        $app->language   = 'en';
        $app->timezone   = 'Asia/Dhaka';
        $app->save();

        $row = new \App\Models\SmsSetting;
        $row->company_id = $user->id;
        $row->save();

        $row = new \App\Models\DisplaySetting;
        $row->company_id = $user->id;
        $row->save();

        \Session::put('app', array(
                'title'   => $app->title, 
                'favicon' => $app->favicon, 
                'logo'    => $app->logo, 
                'timezone' => $app->timezone, 
                'display'  => !empty($display->display)?$display->display:2, 
                'copyright_text' => $app->copyright_text, 
            )); 

        return $user;
    }


    public function signup()
    {
        return view('auth.sign-up');
    }



    public function companyRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'mobile' => 'required|unique:user,mobile',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();

        $user =  User::create([
                    'firstname' => $data['first_name'],
                    'lastname' => $data['last_name'],
                    'email' => $data['email'],
                    'mobile' => $data['mobile'],
                    'password' => bcrypt($data['password']),
                    'department_id' => 0,
                    'user_type' => 5,
                ]);

        $otp = rand(100000, 999999);

        $user = User::find($user->id);
        $user->company_id = $user->id;
        $user->otp = $otp;
        $user->save();

        $app = new \App\Models\Setting;
        $app->company_id = $user->id;
        $app->title   = 'Company Name';
        $app->description   = 'Type description here';
        $app->email   = $user->email;
        $app->copyright_text   = 'Copyright@'.date('Y');
        $app->language   = 'en';
        $app->timezone   = 'UTC';
        $app->save();

        $row = new \App\Models\SmsSetting;
        $row->company_id = $user->id;
        $row->save();

        $row = new \App\Models\DisplaySetting;
        $row->company_id = $user->id;
        $row->save();

        sendSMSByTwilio($user->mobile, "Your One Time Passcode (OTP) is ".$otp." received from Gokiiw");

        $email = $user->email;
        $password = $data['password'];
        $msg = "A One Time Passcode has been sent to phone number. Please enter the OTP below to verify.";

        return view('auth.login')->with(compact('email', 'password', 'msg'));
    }


    public function verifyEmail($email, $token)
    {
        $email = trim($email);
        $token = trim($token);

        if(DB::table('password_resets')->where('email', $email)->where('token', $token)->exists())
        {
            /** update password */
            $row = User::query();

            $row->where('email', $email)
                ->update([
                    'email_verified_at' => now(),
                ]);

            $user = $row->where('email', $email)->first();

            //** Remove reset link */
            DB::table('password_resets')
            ->where('email', $email)
            ->delete();

            // login user by auth method
            Auth::login($user);

            $app = \App\Models\Setting::where('company_id', $user->company_id)->first();
            
            //  put require value in session
            \Session::put('app', array(
                'title'   => $app->title,
                'favicon' => $app->favicon,
                'logo'    => $app->logo,
                'timezone' => $app->timezone,
                // 'display'  => !empty($display->display) ? $display->display : 2, 
                'copyright_text' => $app->copyright_text, 
            )); 

            return redirect(url('/signup-success'))->with('status', 'Welcome to '. env('APP_NAME') .'. Your email address is verified successfully. <a href="/admin" class="btn-link">Go to dashboard</a> ');
        }

        return abort(403, 'Token unauthorized');
    }




    public static function sendVerifyEmail($email, $username)
    {
        $token = Str::random(30);
        $reset_link = url('verify-email/'. $email . '/' .$token);


        if(DB::table('password_resets')->where('email', $email)->exists())
        {
            DB::table('password_resets')
            ->where('email', $email)
            ->update([
                'token' => $token,
                'created_at'    => now(),
            ]);
        }
        else
        {
            DB::table('password_resets')
            ->insert([
                'email' => $email,
                'token' => $token,
                'created_at'    => now(),
            ]);
        }

        try{
            Mail::to($email)->send(new VerifyEmail([
                'subject' => "Welcome to ". env('APP_NAME') .". Please verify your email address",
                'reset_link' => $reset_link,
                'username' => $username,
            ]));
        }catch(Exception $e){
             return back()->with('info', $e->getMessage()); 
        }

        return back()->with('status', 'Hi '.$username.'. <br> We have sent an email to your email address '. $email .'. <br> Please check and verify your email address.');
    }

}
