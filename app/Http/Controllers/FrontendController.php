<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\Token_lib;
use App\Models\AppSettings;
use App\Models\Counter;
use App\Models\Department;
use App\Models\DisplaySetting;
use App\Models\Plan;
use App\Models\Section;
use App\Models\Setting;
use App\Models\SmsHistory;
use App\Models\Token;
use App\Models\TokenSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class FrontendController extends Controller
{
    public function home()
    {
        return redirect(route('login'));
        //return view('frontend.index');
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }


    public function guestLogin(Request $request)
    {
        $token = $request->token;

        $query = User::query();

        if($query->where(['token' => $token])->exists())
        {
            $company = $query->where(['token' => $token])->first();

            $setting = Setting::where('company_id', $company->id)->first();
            @date_default_timezone_set($setting->timezone);
            $today = date("l"); // today
            $now = date("H:i:s"); // present time
            $selectedDays = (!is_null($setting->day_offs)) ? json_decode($setting->day_offs, true) : [];

            // if company is closed
            if(in_array($today, $selectedDays) || $now > $setting->closing_time || $now < $setting->opening_time)
            {
                return view('guest.welcome')->with(compact('setting')); 
            }

            $display = DisplaySetting::where('company_id', $company->company_id)->first();
            $keyList = DB::table('token_setting AS s')
                ->select('d.key', 's.department_id', 's.counter_id', 's.user_id')
                ->leftJoin('department AS d', 'd.id', '=', 's.department_id')
                ->where('d.company_id', $company->company_id)
                ->where('s.status', 1)
                ->get();
            $keyList = json_encode($keyList);

            if ($display->display == 5)
            {
                $departmentList = TokenSetting::select( 
                        'department.name',
                        'token_setting.department_id',
                        'token_setting.counter_id',
                        'token_setting.user_id',
                        DB::raw('CONCAT(user.firstname ," " ,user.lastname) AS officer')
                    )
                    ->join('department', 'department.id', '=', 'token_setting.department_id')
                    ->join('counter', 'counter.id', '=', 'token_setting.counter_id')
                    ->join('user', 'user.id', '=', 'token_setting.user_id')
                    ->where('token_setting.status',1)
                    ->groupBy('token_setting.user_id')
                    ->orderBy('token_setting.department_id', 'ASC')
                    ->get();
            }
            else
            {
                $departmentList = TokenSetting::select( 
                        'department.name',
                        'token_setting.department_id',
                        'token_setting.counter_id',
                        'token_setting.user_id'
                        )
                    ->join('department', 'department.id', '=', 'token_setting.department_id')
                    ->join('counter', 'counter.id', '=', 'token_setting.counter_id')
                    ->join('user', 'user.id', '=', 'token_setting.user_id')
                    ->where('department.company_id', $company->company_id)
                    ->where('token_setting.status', 1)
                    ->groupBy('token_setting.department_id')
                    ->get(); 
            }
            return view('guest.auto', compact('display', 'departmentList', 'keyList', 'company', 'setting'));
        }

        return redirect(route('home'));
    }


    public function guestPhoneCheck(Request $request)
    {
        // check customer phone number is exists or not
        $token = Token::where('client_mobile', $request->client_mobile)
                                    ->where('status', 0)
                                    ->whereDate('created_at', today());
                
        if($token->exists()):
        $data['phoneExists'] = 1;
        $data['tokenId'] = $token->first()->id;
        else:
        $data['phoneExists'] = 0;
        $data['tokenId'] = null;
        endif;

        return $data;
    }


    public function sendOtpToPhone(Request $request)
    {
        $otp = rand(100000, 999999);
        $phone = $data['phone'] = $request->phone;

        $table = DB::table("otps")->where('phone', $phone);

        if($table->exists())
        {
            $table->update(['otp'=>$otp, 'updated_at'=>now()]);
        }
        else
        {
            DB::table("otps")->insert([
                "phone" =>  $phone,
                "otp"   =>  $otp,
                "created_at"   => now(),
                "updated_at"   =>  now(),
            ]);
        }

        $data['twilio_resp'] = sendSMSByTwilio($phone, $otp);
        
        return response()
                ->json([
                    'success' =>    1,
                    'message'   =>  "OTP Send success",
                    'data'  =>  $data
                ]);
    }


    public function guestAutoToken(Request $request)
    {   
        $companyId = $request->companyId;
        @date_default_timezone_set(companyDetails($companyId)->timezone);

        $display = DisplaySetting::where('company_id', $companyId)->first();

        if ($display->sms_alert)
        {
            $validator = Validator::make($request->all(), [
                'client_mobile' => 'required',
                'department_id' => 'required|max:11',
                'counter_id'    => 'required|max:11',
                'user_id'       => 'required|max:11',
                'note'          => 'max:512' 
            ])
            ->setAttributeNames(array( 
               'client_mobile' => trans('app.client_mobile'),
               'department_id' => trans('app.department'),
               'counter_id' => trans('app.counter'),
               'user_id' => trans('app.officer'), 
               'note' => trans('app.note') ,
            )); 
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|max:11',
                'counter_id'    => 'required|max:11',
                'user_id'       => 'required|max:11',
                'note'          => 'max:512'
            ])
            ->setAttributeNames(array( 
               'department_id' => trans('app.department'),
               'counter_id' => trans('app.counter'),
               'user_id' => trans('app.officer'), 
               'note' => trans('app.note'),
            )); 
        }

        //generate a token
        try {
            DB::beginTransaction(); 

            if ($validator->fails() && false) {
                $data['status'] = false;
                $data['exception'] = "<ul class='list-unstyled'>"; 
                $messages = $validator->messages();
                foreach ($messages->all('<li>:message</li>') as $message)
                {
                    $data['exception'] .= $message; 
                }
                $data['exception'] .= "</ul>"; 
                $data['exception'] = $validator->messages()->first();
            } else { 

                // find auto-setting
                $settings = TokenSetting::select('counter_id','section_id','department_id','user_id','created_at')
                        ->where('department_id', $request->department_id)
                        ->whereIn('section_id', $request->section_id)
                        ->groupBy('user_id')
                        ->get();

                //if auto-setting are available
                if (!empty($settings)) { 

                    foreach ($settings as $setting) {
                        //compare each user in today
                        $tokenData = Token::select('department_id','counter_id','section_id','user_id',DB::raw('COUNT(user_id) AS total_tokens'))
                                ->where('department_id',$setting->department_id)
                                ->where('counter_id',$setting->counter_id)
                                ->where('user_id',$setting->user_id)
                                ->where('status', 0)
                                ->whereRaw('DATE(created_at) = CURDATE()')
                                ->orderBy('total_tokens', 'asc')
                                ->groupBy('user_id')
                                ->first();

                        //create user counter list
                        $tokenAssignTo[] = [
                            'total_tokens'  => (!empty($tokenData->total_tokens)?$tokenData->total_tokens:0),
                            'department_id' => $setting->department_id,
                            'section_id' => $setting->section_id,
                            'counter_id'    => $setting->counter_id,
                            'user_id'       => $setting->user_id
                        ]; 
                    }

                    // return $tokenAssignTo;
                    // findout min counter set to 
                    $min = min($tokenAssignTo);
                    $saveToken = [
                        'company_id'    => $companyId,
                        'token_no'      => $this->newToken($min['department_id'], $min['counter_id'], $companyId),
                        'client_mobile' => $request->client_mobile,
                        'department_id' => $min['department_id'],
                        'section_id'    => $min['section_id'],
                        'services'      => json_encode($request->section_id),
                        'counter_id'    => $min['counter_id'],
                        'user_id'       => $min['user_id'],
                        'note'          => $request->note, 
                        'created_by'    => 0,
                        'created_at'    => date('Y-m-d H:i:s'), 
                        'updated_at'    => null,
                        'status'        => 0 
                    ];
                    
                    //     $saveToken = [
                    //         'company_id'    => $companyId,
                    //         'token_no'      => $this->newToken($request['department_id'], $request['counter_id'], $companyId),
                    //         'client_mobile' => $request->client_mobile,
                    //         'department_id' => $request->department_id,
                    //         'section_id'    => $request->section_id ?? 0,
                    //         'counter_id'    => $request->counter_id,
                    //         'user_id'       => $request->user_id,
                    //         'note'          => $request->note, 
                    //         'created_by'    => 0,
                    //         'created_at'    => date('Y-m-d H:i:s'), 
                    //         'updated_at'    => null,
                    //         'status'        => 0 
                    //     ]; 

                
                } else {
                    $saveToken = [
                        'company_id'    => $companyId,
                        'token_no'      => $this->newToken($request->department_id, $request->counter_id, $companyId),
                        'client_mobile' => $request->client_mobile,
                        'department_id' => $request->department_id,
                        'section_id'    => $request->section_id ?? 0,
                        'services'      => json_encode($request->section_id),
                        'counter_id'    => $request->counter_id, 
                        'user_id'       => $request->user_id, 
                        'note'          => $request->note, 
                        'created_at'    => date('Y-m-d H:i:s'),
                        'created_by'    => 0,
                        'updated_at'    => null,
                        'status'        => 0
                    ];               
                }

                // $settings = TokenSetting::select('counter_id','section_id','department_id','user_id','created_at')
                //             ->where('department_id', $request->department_id)
                //             ->whereIn('section_id', $request->section_id)
                //             ->get();

                $token = Token::create($saveToken);
                
                // foreach($settings as $item)
                // {
                //     DB::table('token_services')->create([
                //         'token_id'  =>  $token->id,
                //         'service_id'    =>  $item->section_id,
                //         'counter_id'    =>  $item->counter_id,
                //         'user_id'    =>  $item->user_id,
                //         'status'    =>  0,
                //         'created_at'    =>  now(),
                //         'updated_at'    =>  null,
                //     ]);

                // }

                //store in database  
                //set message and redirect
                if ($token) { 

                    // $token = null;
                    //retrive token info
                    $token = Token::select(
                            'token.*', 
                            'department.name as department', 
                            'counter.name as counter',
                            'sections.name as section',
                            'user.firstname',
                            'user.lastname'
                        )
                        ->leftJoin('department', 'token.department_id', '=', 'department.id')
                        ->leftJoin('sections', 'token.section_id', '=', 'sections.id')
                        ->leftJoin('counter', 'token.counter_id', '=', 'counter.id')
                        ->leftJoin('user', 'token.user_id', '=', 'user.id') 
                        ->where('token.id', $token->id)
                        ->first(); 

                    // token serial
                    $tokenSerial = Token::where('id', '<', $token->id)->where([
                                        'company_id'    => $companyId,
                                        'department_id' => $settings->last()->department_id,
                                        'counter_id'    => $settings->last()->counter_id, 
                                        'section_id'    => $settings->last()->section_id,
                                        'user_id'       => $settings->last()->user_id,
                                        'status'        =>  0
                                    ])->count();

                    $avgTime = (int)($this->getAverageTimeOfCompletingToken($settings->last()->user_id,$companyId) * $tokenSerial);
                    $nextTime = $avgTime + 2;

                    if(!is_null($token->services))
                    {
                        $services = Section::whereIn('id', json_decode($token->services))->pluck('name', 'id')->toArray();
                    }
                    
                    DB::commit();
                    $data['status'] = true;
                    $data['message'] = trans('app.token_generate_successfully');
                    $data['token']  = $token;
                    $data['title']  = companyDetails($companyId)->title;
                    $data['serial'] = $tokenSerial;
                    $data['services'] = $services ?? null;
                    $data['tokenInfo']['rowId'] = $token->id;
                    $data['tokenInfo']['title'] = companyDetails($companyId)->title;
                    $data['tokenInfo']['aprx_time'] = $avgTime . " to " . $nextTime;
                    
                } else {
                    $data['status'] = false;
                    $data['exception'] = trans('app.please_try_again');
                }
            }
            
            // return $data;
            return response()->json($data);
            
        } catch(\Exception $err) {
            DB::rollBack(); 
            return $err->getMessage();
        }
    }


    public function guestAutoTokenEdit($tokenId)
    {
        if($token = Token::find($tokenId))
        {
            $sectionArr = [];
            $sections = [];
            $rows = TokenSetting::where('department_id', $token->department_id)->latest()->get();

            foreach($rows as $row)
            {
                if(!in_array($row->section_id, $sectionArr))
                {   
                    array_push($sectionArr, $row->section_id); // store the section
                    $sections[] = Section::find($row->section_id);
                }
            }

            $data['token'] = $token;
            $data['sections'] = $sections;

            return view('guest.editToken', compact('data'));
        }
        else
        {
            return abort(403, "Token Not Found");
        }
        
    }


    public function guestAutoTokenUpdate(Request $request)
    {
        $request->validate([
            'section_id'    =>  ['required'],
            'time'          =>  ['required'],
            'note'          =>  ['required'],
        ]);

        
        if($token = Token::find($request->tokenId))
        {
            $settings = TokenSetting::select('counter_id','section_id','department_id','user_id','created_at')
                            ->where('department_id', $token->department_id)
                            ->where('section_id', $request->section_id)
                            ->first();

            $saveToken = [
                'company_id'    => $token->company_id,
                'token_no'      => $this->newToken($settings['department_id'], $settings['counter_id'], $token->company_id),
                'client_mobile' => $token->client_mobile,
                'department_id' => $settings->department_id,
                'section_id'    => $settings->section_id ?? 0,
                'counter_id'    => $settings->counter_id,
                'user_id'       => $settings->user_id,
                'note'          => $request->note, 
                'note2'          => $request->note2, 
                'created_by'    => 0,
                'created_at'    => date('Y-m-d'). ' ' . date('H:i:s', strtotime($request->time)),
                'updated_at'    => null,
                'status'        => 0 
            ]; 

            //store in database  
            //set message and redirect
            if ($insert_id = Token::insertGetId($saveToken)) { 

                $token->delete(); //  delete old token
                //retrive token info
                $token = Token::find($insert_id);
            }

            $tokenSerial = Token::where('id', '<', $token->id)->where([
                                'company_id'    => $token->company_id,
                                'department_id' => $token->department_id,
                                'counter_id'    => $token->counter_id, 
                                'section_id'    => $token->section_id,
                                'user_id'       => $token->user_id,
                                'status'        =>  0
                            ])->count();

            $avgTime = (int)($this->getAverageTimeOfCompletingToken($token->user_id,$token->company_id) * $tokenSerial);
            $nextTime = $avgTime + 2;

            $data['apx_time'] = $avgTime . " to " . $nextTime;
            $data['serial'] = $tokenSerial;
            return view('guest.token', compact('data', 'token'));
        }
        else
        {
            return abort(403, "Token Not Found");
        }
    }


    public function getSection(Request $request)
    {
        $rows = TokenSetting::where('department_id', $request->departmentId)
                ->latest()
                ->groupBy('department_id')
                ->groupBy('user_id')
                ->get();

        if($rows->count() > 0)
        {
            $html = '';
            foreach($rows as $row)
            {
                $sections = Section::whereIn('id',json_decode($row->services))->pluck('name', 'id');

                foreach($sections as $id => $val)
                {
                    $html .= "<option value=\"{$id}\">{$val}</option>";
                }
            }
        }

        return response()
                ->json([
                    'html'  => $html ?? 'null',
                    'items'=>    $rows->count()
                ]);
    }



    protected function newToken($department_id = null, $counter_id = null, $companyId = null, $is_vip = null)
    {  
        @date_default_timezone_set(companyDetails($companyId)->timezone); 
       
        $lastToken = Token::where('company_id', $companyId)->whereDate('created_at', date("Y-m-d"))
            ->where(function($query) use($department_id, $counter_id, $is_vip) {
                $query->where('department_id', $department_id)
                    // ->where('counter_id', $counter_id)
                    ->where('counter_id', $counter_id);

                if (!empty($is_vip))
                {
                    $query->where('is_vip', 1);
                }
                else
                {
                    $query->where('is_vip', NULL)
                        ->orWhere('is_vip', '')
                        ->orWhere('is_vip', 0);
                }
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



    public function guestTokenSerial(Request $request)
    {
        // token serial
        // return $request;
        $tokenSerial = Token::where('id', '<=', $request->rowId)
                        ->where([
                            'company_id'    => $request->companyId,
                            'department_id' => $request->departmentId,
                            'counter_id'    => $request->counterId, 
                            'user_id'       => $request->userId,
                            'status'        => 0
                        ])->count();

        $smsLimit = User::find($request->companyId)->sms_limit;

        if($tokenSerial == 2) // if the next serial is yours
        {
            if(SmsHistory::where('company_id', $request->companyId)->count() < $smsLimit)
            {
                $token = Token::find($request->rowId);

                if($token->sms_status == 0)
                {
                    $message = "Next is your turn on ".$request->companyName;
                    $response = sendSMSByTwilioForSerial($request->mobile, $message);
                
                    $sms = new SmsHistory;
                    $sms->company_id  = $request->companyId;
                    $sms->from        = AppSettings::first()->TW_FROM;
                    $sms->to          = $request->mobile;
                    $sms->message     = $message;
                    $sms->response    = $response;
                    $sms->created_at  = date('Y-m-d H:i:s');
                    $sms->save();

                    $token->sms_status = 1;
                    $token->save();
                }

            }
        }

        $avgTime = (int)($this->getAverageTimeOfCompletingToken($request->userId, $request->companyId) * ($tokenSerial - 1));
        $nextTime = $avgTime + 2;

        return response()->json([
            'success'   =>  true,
            'message'   =>  'Query run successfully',
            'data'      =>  [
                'position'    =>  $tokenSerial,
                'serial'    =>  (int)($tokenSerial - 1),
                'avg_time' => $avgTime . " to " . $nextTime,
            ]
        ]);
    }


    /** Get Average time for completing tokens of single user */
    public function getAverageTimeOfCompletingToken($userId, $companyId)
    {
        $user = User::find($userId);

        if(is_null($user->avg_token_completed_time))
        {
            $tokens = Token::where('company_id', $companyId)->where('user_id', $userId)
                    ->where('status', 1)
                    ->get();

            $avgTime = 0;  

            if($tokens->count() > 0)
            {
                $timeDiff = [];

                foreach($tokens as $item)
                {
                    $timeDiff[] = $this->makeCarbonFormat($item->updated_at)->diffInMinutes($this->makeCarbonFormat($item->created_at));
                }

                $totalTime = array_sum($timeDiff);

                $avgTime = $totalTime / $tokens->count();
            }
        }
        else
        {
            $avgTime = (double)$user->avg_token_completed_time;
        }

        return number_format($avgTime, 2, '.', '');
    }


    protected function makeCarbonFormat($time)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $time);
    }


    function showTerms()
    {
        $terms = AppSettings::first()->terms;

        return view('terms', compact('terms'));
    }

    public function showPrivacy()
    {
        return view("privacy");
    }
}
