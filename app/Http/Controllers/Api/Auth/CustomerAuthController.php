<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller{
    
    use ApiResponses;

    /** ------------    Api Login
     * =================================================*/
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  ['required', 'email', 'exists:customers'],
            "password"=>    ['required', 'min:6']
        ]);

        if($validator->fails())
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }


        if(Auth::guard('customer')->attempt($request->only(['email', 'password'])))
        {
            $customer = Customer::find(Auth::guard('customer')->id()); // store customer records
            Auth::guard('customer')->logout(); // auth logout

            $customer->otp = rand(100000, 999999);
            $customer->save();
            
            // send otp to email and phone
            $otpResp = $this->sendOtpToEmailAndPhone($customer->email, $customer->otp);

            // if OTP send failed
            if($otpResp['status'] == false)
            {
                return $this->error($otpResp['message']);
            }

            $user = [
                'userId'    =>  $customer->id,
                'username' =>  $customer->username,
                'email'     =>  $customer->email,
                'phone'    =>  $customer->phone,
            ];

            // return api response
            return $this->success($user, 'A One Time Passcode has been sent to the email address.');
        }
        else
        {
            return $this->error("Credentials do not match our records");
        }
    }


    /** ------------    Register
     * =================================================*/
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" =>  ['required', 'string'],
            "email" =>  ['required', 'email', 'unique:customers'],
            "phone" =>  ['required', 'numeric', 'unique:customers'],
            "password"  =>  ['required', 'min:6'],
            "confirm_password"  =>  ['required', 'same:password', 'min:6']
        ]);

        if($validator->fails()) // after invalid request
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }

        $otp = rand(100000, 999999);

        // create customer profile
        try{
            $customer = Customer::insert([
                'username' =>  $request->username,
                'email' =>  $request->email,
                'phone' =>  $request->phone,
                'password' =>  bcrypt($request->confirm_password),
                'otp'       =>  $otp,
                'otp_send_at'  => now(),
                'created_at'  => now(),
            ]);
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage());
        }

        // send OTP to email and phone
        $resp = $this->sendOtpToEmailAndPhone($request->email, $otp);

        if($resp['status'] == false)
        {
            return $this->error($resp['message']);
        }

        return $this->success($request->only('username', 'email', 'phone'), "Record created successfully. Please enter the OTP in 2 minutes.");
    }



    /** ------------    Check OTP
     * =================================================*/
    public function checkOtpAndLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  ['required', 'email', 'exists:user'],
            "password"  =>  ['required', 'min:6'],
            "otp"=>    ['required', 'min:6'],
        ]);

        if($validator->fails())
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }

        if(Auth::guard('customer')->attempt($request->only(['email', 'password', 'otp'])))
        {
            $customer = Customer::find(Auth::guard('customer')->id());
            Auth::guard('customer')->logout();

            $expiredAt = \Carbon\Carbon::parse($customer->otp_send_at)->addMinutes(2);

            if($expiredAt > now())
            {
                return $this->error("OTP Expired", 400, $request->only('email', 'otp'));
            }

            $bearerToken = $customer->createToken($customer->username)->plainTextToken;

            $data = [
                'bearer_token'  =>  $bearerToken,
                'user' =>  [
                    'userId'    =>  $customer->id,
                    'username' =>  $customer->username,
                    'email'     =>  $customer->email,
                    'phone'    =>  $customer->phone,
                ]
            ];

            // return api response
            return $this->success($data, 'OTP matched successfully');
        }
        else
        {
            // return api response
            return $this->error('Otp Not Matched. Please enter valid OTP');
        }
    }



    /** ------------    Send OTP to Email and Phone
     * =================================================*/
    protected function sendOtpToEmailAndPhone($email, $otp = null, $phone = null)
    {
        $otp = (is_null($otp)) ? rand(100000, 999999) : $otp; // 6 digits OTP
        $status = true;
        $msg = 'SMTP Called Successfully';

        try{
            
            // send email
            Mail::to($email)->send(new OtpEmail(['otp'=>$otp]));
            
            if(!is_null($phone)) // send sms
            {
                sendSMSByTwilio($phone, "Your One Time Passcode (OTP) is ".$otp." received from Gokiiw");
            }
        
        }catch(Exception $e)
        {
            $msg = 'Exception Message: '. $e->getMessage();
            $status = false;
        }

        return [
            'otp'   =>  $otp,
            'status'=>  $status,
            'message'   =>  $msg
        ];
    }


}