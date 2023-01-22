<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller{
    
    use ApiResponses;

    /** ------------    Api Login
     * =================================================*/
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  ['required', 'email', 'exists:user'],
            "password"=>    ['required', 'min:8']
        ]);

        if($validator->fails())
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }


        if(Auth::attempt($request->only(['email', 'password'])))
        {
            $user = Auth::user(); // store user records
            Auth::logout(); // auth logout

            $data = [
                'user' =>  [
                    'userId'    =>  $user->id,
                    'name' =>  $user->firstname.' '.$user->lastname,
                    'email'     =>  $user->email,
                    'mobile'    =>  $user->mobile,
                    'companyId'   =>  $user->company_id,
                    'companyName'   =>  $user->setting->title,
                ]
            ];

            if($user->status == 0) // restricted user
            {
                $message = trans('app.contact_with_authurity');
                return $this->success($data['user'], $message);
            }

            // send otp to email and phone
            $otpResp = $this->sendOtpToEmailAndPhone($user->email, $user->mobile);

            // if OTP send failed
            if($otpResp['status'] == false)
            {
                return $this->error($otpResp['message']);
            }

            // otp update in database
            User::find($user->id)->update(['otp'=>$otpResp['otp']]);

            // return api response
            return $this->success($data['user'], 'A One Time Passcode has been sent to your phone number and email address.');
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
            "first_name" =>  ['required', 'string'],
            "last_name" =>  ['required', 'string'],
            "email" =>  ['required', 'email', 'unique:user'],
            "mobile" =>  ['required',    'unique:user'],
            "password"=>    ['required', 'min:8', 'confirmed'],
            "company_name" =>  ['required', 'unique:setting,title'],
            'company_email' =>  ['required', 'unique:setting,email'],
            'company_phone' =>  ['required', 'unique:setting,phone'],
            'company_address' =>  ['required', 'string'],
            'timezone' =>  ['required', 'string'],
        ]);

        if($validator->fails()) // after invalid request
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }

        // send OTP to email and phone
        $resp = $this->sendOtpToEmailAndPhone($request->email, $request->mobile);

        if($resp['status'] == false)
        {
            return $this->error($resp['message']);
        }

        // create user profile
        $user = User::create([
            'firstname' =>  $request->first_name,
            'lastname' =>  $request->last_name,
            'email' =>  $request->email,
            'mobile' =>  $request->mobile,
            'password' =>  bcrypt($request->password),
            'department_id' => 0,
            'user_type' => 5,
            'otp'       =>  $resp['otp']
        ]);

        // assign company Id
        User::find($user->id)->update(['company_id'=>$user->id]);

        // create company profile
        $company = Setting::insert([
            'company_id' =>  $user->id,
            'title' =>  $request->company_name,
            'description'   =>  "Type description here",
            'email' =>  $request->company_email,
            'phone' =>  $request->company_phone,
            'copyright_text'    =>  'Copyright@'.date('Y'),
            'language'  =>  'en',
            'timezone'  =>  $request->timezone,
        ]);

        // create SMS setings
        $row = new \App\Models\SmsSetting;
        $row->company_id = $user->id;
        $row->save();

        //  create display settings
        $row = new \App\Models\DisplaySetting;
        $row->company_id = $user->id;
        $row->save();


        return $this->success([
            'user_id'    =>  $user->id,
            'comapny_id'    =>  $user->id,
            'comapny_name'    =>  $request->company_name,
            'name'  =>  $user->firstname . ' ' . $user->lastname,
            'email' =>  $user->email, 
            'mobile' =>  $user->mobile,  
        ], "User created successfully");

    }



    /** ------------    Check OTP
     * =================================================*/
    public function checkOtpAndLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  ['required', 'email', 'exists:user'],
            "password"=>    ['required', 'min:8'],
            "otp"=>    ['required', 'min:6', 'max:6'],
        ]);

        if($validator->fails())
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }

        if(Auth::attempt($request->only(['email', 'password', 'otp'])))
        {
            $user = Auth::user();
            Auth::logout();

            $bearerToken = $user->createToken($user->firstname)->plainTextToken;

            $data = [
                'bearer_token'  =>  $bearerToken,
                'user' =>  [
                    'user_id'    =>  $user->id,
                    'name' =>  $user->firstname.' '.$user->lastname,
                    'email'     =>  $user->email,
                    'mobile'    =>  $user->mobile,
                    'company_id'   =>  $user->company_id,
                    'company_name'   =>  $user->setting->title,
                ]
            ];

            // return api response
            return $this->success($data, 'Token matched successfully');
        }
        else
        {
            // return api response
            return $this->error('Otp Not Matched. Please enter valid OTP');
        }
    }



    /** ------------    Send OTP to Email and Phone
     * =================================================*/
    protected function sendOtpToEmailAndPhone($email, $phone)
    {
        $otp = rand(100000, 999999); // 6 digits OTP
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