<?php

function getCompanyDetails(string $userId)
{
    $user = \App\Models\User::find($userId);

    $company = \App\Models\User::find($user->company_id);

    return $company;
}

function companyDetails(int $companyId)
{
    $company = \App\Models\Setting::where('company_id', $companyId)->first();

    return $company;
}


function companyOwner(string $userId)
{
    $user = \App\Models\User::find($userId);

    $company = \App\Models\User::find($user->company_id);

    return $company;
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
?>