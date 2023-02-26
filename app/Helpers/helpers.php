<?php

use Illuminate\Support\Facades\Auth;

function getCompanyDetails(string $userId)
{
    $user = \App\Models\User::find($userId);

    $company = \App\Models\User::find($user->company_id);

    return $company;
}

function companyDetails($companyId)
{
    $company = \App\Models\Setting::where('company_id', $companyId)->first();

    return $company;
}

function companyToken($companyId)
{
    $company = \App\Models\User::find($companyId);

    return $company->token ?? '1234';
}


function companyOwner(string $userId)
{
    $user = \App\Models\User::find($userId);

    $company = \App\Models\User::find($user->company_id);

    return $company;
}

function defaultCountryCode($userId)
{
    $user = \App\Models\User::find($userId);

    $company = \App\Models\Setting::where('company_id', $user->company_id)->first();

    return $company->country_code;
}


function UserRoles()
{
    return \App\Models\UserType::where('company_id', auth()->user()->company_id)->get();
}


function sendSMSByTwilio($receiverNumber = "01533448761", $message= "Default SMS from gokiiw")
{
    try{

        $twilio = \App\Models\AppSettings::first();
        $account_sid = $twilio->TW_SID;
        $auth_token = $twilio->TW_TOKEN;
        $twilio_number = $twilio->TW_FROM;

        $client = new \Twilio\Rest\Client($account_sid, $auth_token);
        $response = $client->messages->create($receiverNumber, ['from' => $twilio_number, 'body' => $message]);

    }catch(\Exception $e){
        $response = $e->getMessage();
    }

    return $response;
}

function sendOtpToPhone(int $userId)
{
    $otp = rand(100000, 999999);

    $user = \App\Models\User::find($userId);
    $user->otp = $otp;
    $user->save();

    $response = sendSMSByTwilio($user->mobile, 'Your One Time Passcode (OTP) is '. $otp .' received from Gokiiw');

    return $response;
}


function checkMobileOtp(int $inputOtp, int $userId){

    $user = \App\Models\User::find($userId);

    if($user->otp == $inputOtp)
    {
        return true;
    }
    return false;
}


function userAccessList()
{
    return [
        "location" => [
            "read"  =>  1,
            "write"  => 1,
        ],
        "section" => [
            "read"  =>  1,
            "write"  => 1,
        ],
        "counter" => [
            "read"  =>  1,
            "write"  => 1,
        ],
        "user_type" => [
            "read"  =>  1,
            "write"  => 1,
        ],
        "users" => [
            "read"  =>  1,
            "write"  => 1,
        ],
        "sms" => [
            "read"  =>  1,
            "write"  => 1,
        ],
        "token" => [
            "auto_token"    => 1,
            "manual_token"    => 1,
            "performance_report"    => 1,
            "auto_token_setting"    => 1,
            "active_token"    => [
                'own_token' =>  1,
                'all_token' =>  1,
                // 'read'  =>  1,
                // 'write' =>  1
            ],
            "token_report"    => [
                'read'  =>  1,
                'write' =>  1
            ],
            
        ],
        "display"   =>  1,
        "message"   =>  1,
        "admin_dashboard"   =>  1,
        "setting"   =>  [
            'app_setting'   =>  1,
            'subsription'   =>  1,
            'display_setting'   =>  1,
            'profile_information'   =>  1,
        ]
    ];
}


function issetAccess($roleId)
{
    if(is_null($roleId))
    {
        return (object)userAccessList();
    }
    else
    {
        $userRole = \App\Models\UserType::find($roleId);

        if(!is_null($userRole->roles))
        $roles = (object)json_decode($userRole->roles, true);
        else
        $roles = (object)userAccessList();
        return $roles;
    }
}
?>