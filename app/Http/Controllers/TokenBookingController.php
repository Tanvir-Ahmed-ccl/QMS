<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Department;
use App\Models\DisplaySetting;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Token;
use App\Models\TokenSetting;
use App\Models\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenBookingController extends Controller
{
    public function index()
    {
        @date_default_timezone_set(session('app.timezone'));

        $tokens = Token::whereHas('department', function($q)
        {
            $q->where('company_id', auth()->user()->company_id);
        })
        ->where('status', '0')
        ->where('created_at', '>', today())
        ->orderBy('is_vip', 'DESC')
        ->orderBy('id', 'ASC')
        ->get();        

        $counters = Counter::where('company_id', auth()->user()->company_id)->where('status',1)->pluck('name','id');
        $departments = Department::where('company_id', auth()->user()->company_id)->where('status',1)->pluck('name','id');
        $officers = User::select(DB::raw('CONCAT(firstname, " ", lastname) as name'), 'id')
            ->where('company_id', auth()->user()->company_id)
            ->where('user_type',1)
            ->where('status',1)
            ->orderBy('firstname', 'ASC')
            ->pluck('name', 'id');

        return view('backend.admin.book.list')->with(compact('counters', 'departments', 'officers', 'tokens'));
    }






    /**
     * 
     */
    public function showTokenBooking($componayToken)
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


    public function storeBooking(Request $request)
    {
        // return $request;
        $companyId = (int)$request->companyId;
        $response = [];
        
        if(DB::table("otps")->where(['phone' => $request->client_mobile, 'otp' => $request->otp])->exists())
        {
            // DB::table("otps")->where(['phone' => $request->client_mobile, 'otp' => $request->otp])->delete();

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
                'created_at'    => date('Y-m-d H:i:s', strtotime($request->date)), 
                'updated_at'    => null,
                'status'        => 0 
            ]; 

            //store in database  
            //set message and redirect
            if ($insert_id = Token::insertGetId($saveToken)) { 

                $token = null;
                //retrive token info
                $token = Token::where('token.id', $insert_id)->first(); 

                
                
            } else {
                $response['status'] = false;
                $response['exception'] = trans('app.please_try_again');
            }
            
        }
        else
        {
            $response['status'] = false;
            $response['exception'] = "OTP not matched";
        }

        return view('bookToken.index', compact('token', 'response'));
    }



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
}
