<?php

namespace App\Http\Controllers;

use App\Models\AppSettings;
use App\Models\Counter;
use App\Models\Department;
use App\Models\DisplaySetting;
use App\Models\Section;
use App\Models\Setting;
use App\Models\SmsHistory;
use App\Models\Token;
use App\Models\TokenSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TokenBookingController extends Controller
{

    /**
     * 
     */
    public static function showTokenBooking($componayToken)
    {
        $query = User::query();

        if($query->where(['token' => $componayToken])->exists())
        {
            $company = $query->where(['token' => $componayToken])->first();

            $setting = Setting::where('company_id', $company->id)->first();
            @date_default_timezone_set($setting->timezone);
            $today = date("l"); // today
            $now = date("H:i:s"); // present time
            $selectedDays = (!is_null($setting->day_offs)) ? json_decode($setting->day_offs, true) : [];

            $data = [];

            $locations = TokenSetting::select( 
                        'department.name',
                        'token_setting.department_id',
                        'token_setting.section_id',
                        'token_setting.counter_id',
                        'token_setting.user_id'
                    )
                    ->join('department', 'department.id', '=', 'token_setting.department_id')
                    ->join('sections', 'sections.id', '=', 'token_setting.section_id')
                    ->join('counter', 'counter.id', '=', 'token_setting.counter_id')
                    ->join('user', 'user.id', '=', 'token_setting.user_id')
                    ->where('department.company_id', $company->company_id)
                    ->where('token_setting.status', 1)
                    ->groupBy('token_setting.department_id')
                    ->get(); 

            foreach($locations as $item)
            {
                $sections = TokenSetting::select( 
                        'sections.name',
                        'sections.id',
                    )
                    ->join('sections', 'sections.id', '=', 'token_setting.section_id')
                    ->where('token_setting.department_id', $item->department_id)
                    ->where('token_setting.status', 1)
                    ->groupBy('token_setting.section_id')
                    ->get(); 

                $data[] = [
                    'location' => $item,
                    'sections'  =>  $sections,
                ];
            }

            // return $data;
            return view('bookToken.index', compact('data', 'setting'));
        }

        return redirect(route('home'));
    }


    /**
     * 
     */
    public function storeBooking(Request $request)
    {
        // return $request;
        $companyId = (int)$request->companyId;
        $response = [];
        $data = $request->all();

        $token = Token::where('department_id', $request->department_id)
                    ->where('section_id', $request->section_id)
                    ->where('status', 0)
                    ->where('created_at', "=", date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time)));
        
        if(!$token->exists())
        {
            $setting = TokenSetting::select('counter_id','section_id','department_id','user_id','created_at')
                ->where('department_id', $request->department_id)
                ->where('section_id', $request->section_id)
                ->first();

            $saveToken = [
                'company_id'    => $companyId,
                'token_no'      => $this->newToken($request->date, $setting['department_id'], $setting['counter_id'], $companyId),
                'client_mobile' => $request->client_mobile,
                'department_id' => $setting->department_id,
                'section_id'    => $setting->section_id ?? 0,
                'counter_id'    => $setting->counter_id,
                'user_id'       => $setting->user_id,
                'note'          => $request->note, 
                'note2'          => $request->note2, 
                'created_by'    => 0,
                'created_at'    => date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time)), 
                'updated_at'    => null,
                'status'        => 0 
            ]; 


        
            //store in database  
            //set message and redirect
            if ($insert_id = Token::insertGetId($saveToken)) { 

                $token = null;
                //retrive token info
                $token = Token::where('token.id', $insert_id)->first(); 

                return view('bookToken.token', compact('token'));
                
            } else {
                return abort(403, 'Something Went wrong. Please Try Again');
            }
        }
        else
        {
            $client_mobile = $request->client_mobile;
            $sections = TokenSetting::select( 
                            'sections.name',
                            'sections.id',
                        )
                        ->join('sections', 'sections.id', '=', 'token_setting.section_id')
                        ->where('token_setting.department_id', $data['department_id'])
                        ->where('token_setting.status', 1)
                        ->groupBy('token_setting.section_id')
                        ->get();

            $status = "This time is already engagaged";
            return view('bookToken.infoForm', compact('data', 'client_mobile', 'sections', 'status'));
        }
    
        
    }

    /** 
     * 
    */
    public function showAuthPage(Request $request)
    {
        $data = $request->all();

        return view('bookToken.auth', compact('data'));
    }


    public function sendOtpToPhone(Request $request)
    {
        $data = $request->all();
        $otp = rand(100000, 999999);
        $client_mobile = $request->client_mobile;

        $table = DB::table("otps")->where('phone', $client_mobile);

        if($table->exists())
        {
            $table->update(['otp'=>$otp, 'created_at'=>now()]);
        }
        else
        {
            DB::table("otps")->insert([
                "phone" =>  $client_mobile,
                "otp"   =>  $otp,
                "created_at"   => now(),
                "updated_at"   =>  now(),
            ]);
        }

        $resp = sendSMSByTwilio($client_mobile, $otp);
        

        return view('bookToken.auth', compact('data', 'client_mobile'));

    }


    public function checkOtp(Request $request)
    {
        $data=  $request->all();
        $client_mobile = $request->client_mobile;

        if(DB::table("otps")->where(['phone' => $request->client_mobile, 'otp' => $request->otp])->exists())
        {
            $otpRow = DB::table("otps")->where(['phone' => $request->client_mobile, 'otp' => $request->otp])->first();

            $expiredAt = \Carbon\Carbon::parse($otpRow->created_at)->addMinutes(2);

            if($expiredAt < now()) // otp expired
            {
                $status = "OTP Expired";
                return view('bookToken.auth', compact('data', 'status', 'client_mobile'));
            }
            else
            {
                DB::table("otps")->where(['phone' => $request->client_mobile, 'otp' => $request->otp])->delete();

                $token = Token::where('status', 0)->where('client_mobile', $request->client_mobile)->where('created_at', '>', date('Y-m-d H:i:m', strtotime(\Carbon\Carbon::now()->addMinutes(5))));
                if($token->exists()) // already token exists
                {
                    $token = $token->first();
                    $tokenExists = true;
                    return view('bookToken.token', compact('token', 'tokenExists'));
                }
                else
                {
                    $sections = TokenSetting::select( 
                                'sections.name',
                                'sections.id',
                            )
                            ->join('sections', 'sections.id', '=', 'token_setting.section_id')
                            ->where('token_setting.department_id', $data['department_id'])
                            ->where('token_setting.status', 1)
                            ->groupBy('token_setting.section_id')
                            ->get(); 

                    return view('bookToken.infoForm', compact('data', 'client_mobile', 'sections'));
                }
            }
        }
        else
        {
            $status = "OTP Not Matched";
            return view('bookToken.auth', compact('data', 'status', 'client_mobile'));
        }
    }


    public function editAppointment(Request $request)
    {
        if($token = Token::find($request->token_id))
        {   
            $data = [
                'department_id' =>  $token->department_id,
                'section_id' =>  $token->section_id,
                'counter_id' =>  $token->counter_id,
                'user_id' =>  $token->user_id,
                'client_mobile' =>  $token->client_mobile,
                'companyId' =>  $token->company_id,
            ];
            $client_mobile = $token->client_mobile;

            $sections = TokenSetting::select( 
                            'sections.name',
                            'sections.id',
                        )
                        ->join('sections', 'sections.id', '=', 'token_setting.section_id')
                        ->where('token_setting.department_id', $data['department_id'])
                        ->where('token_setting.status', 1)
                        ->groupBy('token_setting.section_id')
                        ->get(); 
            $tokenEdit = true;

            return view('bookToken.infoForm', compact('data', 'client_mobile', 'sections', 'token'));
        }
        else
        {
            return abort(404);
        }

        
    }

    public function updateAppointment(Request $request)
    {
        if($token = Token::find($request->token_id))
        {   
            $token->update([
                'created_at'    => date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time)), 
            ]);

            return view('bookToken.token', compact('token'));
        }
        else
        {
            return abort(404);
        }
    }


    /**
     * 
     */
    protected function newToken($date, $department_id = null, $counter_id = null, $companyId = null, $is_vip = null)
    {  
        @date_default_timezone_set(companyDetails($companyId)->timezone); 
       
        $lastToken = Token::where('company_id', $companyId)->whereDate('created_at', $date)
            ->where(function($query) use($department_id, $counter_id) {
                $query->where('department_id', $department_id)
                    ->where('counter_id', $counter_id);
            })
            ->orderBy('token_no','desc')
            ->value('token_no');
	 
		$prefixVIP        = (!empty($is_vip)?"V":"");
        $department       = Department::where('company_id', $companyId)->where('id', $department_id)->value('key');
        $prefixDepartment = ucfirst(mb_substr($department, 0, 1));
        $counter          = Counter::where('company_id', $companyId)->where('id', $counter_id)->value('key');
    	$prefixCounter    = ucfirst(mb_substr($counter, 0, 1));

        if (empty($lastToken))
        {
            $token = $prefixVIP.$prefixDepartment.$prefixCounter.'000';
        }
        else
        {
        	if (empty($is_vip))
        	{
	            $prefix = mb_substr($lastToken, 0, 1).mb_substr($lastToken, 1, 1);
	            $number = mb_substr($lastToken, 2, 1).mb_substr($lastToken, 3, 1).mb_substr($lastToken, 4, 1);
        	}
        	else
        	{
	            $prefix = mb_substr($lastToken, 0, 1).mb_substr($lastToken, 1, 1).mb_substr($lastToken, 2, 1);
	            $number = mb_substr($lastToken, 3, 1).mb_substr($lastToken, 4, 1).mb_substr($lastToken, 5, 1);
        	}

            if ($number < 999) 
            {
                $token = $prefix.sprintf("%03d", $number+1);
            } 
            else 
            {
                $token = $prefix.'000';
            }
        } 

        return strtoupper($token);   
    }


    public function onDeveloping()
    {
        $data = [
            'department_id' => 54,
            'counter_id' => 75,
            'user_id' => 142,
            'companyId' => 65,
            'client_mobile' =>  "+8801940204058"
        ];

        $client_mobile = "+8801940204058";

        $sections = TokenSetting::select( 
                        'sections.name',
                        'sections.id',
                    )
                    ->join('sections', 'sections.id', '=', 'token_setting.section_id')
                    ->where('token_setting.department_id', $data['department_id'])
                    ->where('token_setting.status', 1)
                    ->groupBy('token_setting.section_id')
                    ->get(); 

        return view('bookToken.infoForm', compact('data', 'client_mobile', 'sections'));
    }


    public function sendReminder()
    {
        $tokens = Token::whereDate('created_at', '>=', today())->get();

        foreach($tokens as $token)
        {
            $diff_in_minutes = Carbon::createFromFormat('Y-m-d H:s:i', $token->created_at)->diffInMinutes(now());

            $app = Setting::where('company_id', $token->company_id)->first();
            $beforeMinutes = $app->reminder_for_booking;

            if($diff_in_minutes <= $beforeMinutes)
            {
                $sendMsg = DB::table('reminders')->where('type', 'reminder')->where('target_table', 'tokens')->where('target_id'. $token->id);

                $message = "SMS Sended";

                if(!$sendMsg->exists()):

                    $response = sendSMSByTwilioForBookingReminder($token->client_mobile, [
                                    'datetime'  =>  date("Y-m-d H:i:s", strtotime($token->created_at)),
                                    'companyName'   =>  $app->title,
                                    'location'      =>  $token->department->name
                                ]);

                    $sms = new SmsHistory;
                    $sms->company_id  = $token->companyId;
                    $sms->from        = AppSettings::first()->TW_FROM;
                    $sms->to          = $token->client_mobile;
                    $sms->message     = "Send Reminder for booked appointment";
                    $sms->response    = $response;
                    $sms->created_at  = date('Y-m-d H:i:s');
                    $sms->save();

                    DB::table('reminders')->insert([
                        'type'  => 'reminder',
                        'created_at'    =>  date('Y-m-d H:i:s'),
                        'updated_at'    =>  date('Y-m-d H:i:s'),
                        'target_table'  =>  'tokens',
                        'target_id'  =>  $token->id,
                    ]);

                    $message = $sms->message;
                endif;
            }

            echo "Token No: {$token->token_no} <br/>";
            echo "Client Mobile: {$token->client_mobile} <br/>";
            echo "Date: {$token->created_at} <br/>";
            echo "Message: $message <br/>";
            echo "==================================================== <br/>";
        }


        return "Cron Job Running successfully";
    }
}
