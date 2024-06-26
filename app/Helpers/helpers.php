<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

function getCompanyDetails(string $userId)
{
    $user = \App\Models\User::find($userId);

    $company = \App\Models\User::find($user->company_id);

    if($user->company_id == 0)
    {
        return $user;
    }

    return $company;
}

function companyDetails($companyId)
{
    $company = \App\Models\Setting::where('company_id', $companyId)->first();

    return $company;
}

/**
 * get services name
 * 
 * @return string
 */
function services($serv, $returnType = "str", $column = 'name')
{
    if(!is_array($serv))
    {
        $serv = json_decode($serv);
    }

    $names = \App\Models\Section::whereIn('id', $serv)->pluck($column)->toArray();

    if($returnType == "str" || $returnType == "string"):

        return implode(", ", $names);

    elseif($returnType == "array"):

        return $names;
        
    endif;
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

    if($user->conpany_id == 0)
    {
        return $user;
    }

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


function sendSMSByTwilio($receiverNumber, $otp)
{
    try{
        // $message = "Security code is " . $otp;
        
        $phoneNumberId = env("WHATSAPP_BUSINESS_PHONE_NUMBER_ID");
        $AccessToken = env("WHATSAPP_BUSINESS_ACCESS_TOKEN");

        $headers = [
            "Authorization" => "Bearer {$AccessToken}",
            "Accept" => "application/json"
        ];

        $body = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "$receiverNumber",
            "type" => "template", 
            "template" => [
                "name" => "verification_code",
                "language" => [
                    "code" => "en"
                ],
                "components" => [
                    [
                        "type"=> "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => "$otp"
                            ]
                        ]
                    ],
                    [
                        "type" => "button",
                        "sub_type" => "url",
                        "index" => "0",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => "$otp"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $resp = Http::withoutVerifying()
        ->withHeaders($headers)
        ->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", $body);

        $response = true;

        // $twilio = \App\Models\AppSettings::first();
        // $account_sid = $twilio->TW_SID;
        // $auth_token = $twilio->TW_TOKEN;
        // $twilio_number = $twilio->TW_FROM;

        // $client = new \Twilio\Rest\Client($account_sid, $auth_token);
        // $response = $client->messages->create($receiverNumber, ['from' => $twilio_number, 'body' => $message]);

    }catch(\Exception $e){
        $response = $e->getMessage();
    }

    return $response;
}

function sendSMSByTwilioForBookingReminder($receiverNumber, array $data=[])
{
    try{
        $message = "You have an appointment at {$data['datetime']} in {$data['companyName']}, {$data['location']}";

        $phoneNumberId = env("WHATSAPP_BUSINESS_PHONE_NUMBER_ID");
        $AccessToken = env("WHATSAPP_BUSINESS_ACCESS_TOKEN");

        $headers = [
            "Authorization" => "Bearer {$AccessToken}",
            "Accept" => "application/json"
        ];

        $body = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "$receiverNumber",
            "type" => "template", 
            "template" => [
                "name" => "appointment",
                "language" => [
                    "code" => "en"
                ],
                "components" => [
                    [
                        "type"=> "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => "$message"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        Http::withoutVerifying()
        ->withHeaders($headers)
        ->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", $body);

        $response = true;

        // $twilio = \App\Models\AppSettings::first();
        // $account_sid = $twilio->TW_SID;
        // $auth_token = $twilio->TW_TOKEN;
        // $twilio_number = $twilio->TW_FROM;

        // $client = new \Twilio\Rest\Client($account_sid, $auth_token);
        // $response = $client->messages->create($receiverNumber, ['from' => $twilio_number, 'body' => $message]);

    }catch(\Exception $e){
        $response = $e->getMessage();
    }

    return $response;
}


function sendSMSByTwilioForSerial($receiverNumber = "01533448761", $message = "Gokiiw")
{
    try{
        // $message = "Security code for Gokiiw is " . $otp;

        // $twilio = \App\Models\AppSettings::first();
        // $account_sid = $twilio->TW_SID;
        // $auth_token = $twilio->TW_TOKEN;
        // $twilio_number = $twilio->TW_FROM;

        // $client = new \Twilio\Rest\Client($account_sid, $auth_token);
        // $response = $client->messages->create($receiverNumber, ['from' => $twilio_number, 'body' => $message]);

        $phoneNumberId = env("WHATSAPP_BUSINESS_PHONE_NUMBER_ID");
        $AccessToken = env("WHATSAPP_BUSINESS_ACCESS_TOKEN");

        $headers = [
            "Authorization" => "Bearer {$AccessToken}",
            "Accept" => "application/json"
        ];

        $body = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "$receiverNumber",
            "type" => "template", 
            "template" => [
                "name" => "next_turn",
                "language" => [
                    "code" => "en"
                ]
            ]
        ];

        $resp = Http::withoutVerifying()
        ->withHeaders($headers)
        ->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", $body);

        $response = true;

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