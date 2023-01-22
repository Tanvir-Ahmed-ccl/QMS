<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use App\Models\DisplayCustom;
use App\Models\Setting;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    public function showLogin()
    {  
        return view('auth.login');
    }


    public function send2FA(Request $request)
    {
        //start login throttoling
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return redirect('login')->with('exception', trans('app.to_many_login_attempts'));
        }
        $this->incrementLoginAttempts($request);
        //end login throttoling

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {

            $authUser = Auth::user();

            // if(is_null($authUser->email_verified_at))
            // {
            //     // send verification mail first
            //     \App\Http\Controllers\Auth\RegisterController::sendVerifyEmail(auth()->user()->email, auth()->user()->username);

            //     Auth::logout(); 
            //     return redirect('login')->with('exception', 'We have sent an email to your email address. Please check and verify your email address');
            // }

            if ($authUser->status == '0') 
            {
                Auth::logout();
                return redirect('login')->with('exception', trans('app.contact_with_authurity'));
            } 
            else if (!empty($authUser->user_type)) 
            {
                $otp = rand(100000, 999999);
                $email = $request->email;
                $password = $request->password;
                User::find($authUser->id)->update(['otp'=>$otp]);
                $phone = $authUser->mobile;

                Auth::logout();

                $msg = "A One Time Passcode has been sent to your phone number and email address. Please enter the OTP below to verify.";

                try{
                    Mail::to($authUser->email)->send(new OtpEmail(['otp'=>$otp]));

                    if(!is_null($phone)){
                        //Send otp in mobile
                        sendSMSByTwilio($phone, "Your One Time Passcode (OTP) is ".$otp." received from Gokiiw");
                    }
                }catch(Exception $e){                    
                    $msg = 'Exception Message: '. $e->getMessage();
                }

                return view('auth.login')->with(compact('email', 'password', 'msg'));

            }
            else 
            {
                Auth::logout(); 
                return redirect('login')->with('exception', trans('app.contact_with_authurity'));
            }

        }else{
            return back()
                    ->withInput()
                    ->with('exception', trans('app.invalid_credential'));
        }
    } 


    public function checkOtpAndLogin(Request $request)
    {

        $email = $request->email;
        $password = $request->password;
        $user = User::where(['email' => $email]);

        if($user->exists())
        {
            $otp = $user->first()->otp;

            if($request->otp == $otp)
            {
                $user->update(['otp'=>null, 'email_verified_at' => now()]);
            
                if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {

                    $authUser = Auth::user();            

                    $app = Setting::where('company_id', $authUser->company_id)->first(); 
                    $customDisplays = DisplayCustom::where('company_id', $authUser->company_id)->where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id');
                    if (!empty($customDisplays))
                    {
                        Session::put('custom_displays', $customDisplays); 
                    }

                    if(!empty($app))
                    {
                        Session::put('app', array(
                            'title'   => $app->title, 
                            'favicon' => $app->favicon, 
                            'logo'    => $app->logo, 
                            'timezone' => $app->timezone, 
                            // 'display'  => !empty($display->display)?$display->display:2, 
                            'copyright_text' => $app->copyright_text, 
                        )); 
                    }
                    
                    return redirect(strtolower(auth()->user()->role()));
                }

            }
            else
            {
                $msg = 'Otp Not Matched. Please enter valid OTP';
                return view('auth.login')->with(compact('email', 'password', 'msg'));
            }
        }

        $msg = 'Unauthorized request';
        return view('auth.login')->with(compact('email', 'password', 'msg'));
    }


    public function resendOtp(Request $request)
    {
        $otp = rand(100000, 999999);
        $email = $request->email;
        $password = $request->password;

        $user = User::where(['email' => $email]);
        $phone = $user->first()->mobile;
        $user->update(['otp'=>$otp]);
        $msg = "A One Time Passcode has been resent to your email and phone number. Please enter the OTP below to verify.";

        try{
            // send otp in email address
            Mail::to($email)->send(new OtpEmail(['otp'=>$otp]));

            if(!is_null($phone)){
                //Send otp in mobile
                sendSMSByTwilio($phone, "Your One Time Passcode (OTP) is ".$otp." received from Gokiiw");
            }

        }catch(Exception $e){                    
            $msg = $e->getMessage();
        }

        return view('auth.login')->with(compact('email', 'password', 'msg'));
    }
}
