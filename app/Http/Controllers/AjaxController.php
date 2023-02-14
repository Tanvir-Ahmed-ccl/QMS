<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\TokenSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function section(Request $request)
    {
        $counter = TokenSetting::where('department_id', $request->key)
                    ->get();
        
        $html = '<label for="section_id">Service<i class="text-danger">*</i></label><br/>
                        <select name="section_id" class="form-control"
                            onchange="loadCounter(this.value)"
                        >
                            <option value="">Select One</option>';


        foreach($counter as $item)
        {
            $html .= '<option value="'. $item->section->id .'">'. $item->section->name .'</option>';
        }

        $html .= "</select>";

        return $html;
    }



    public function counter(Request $request)
    {
        $counter = TokenSetting::where('section_id', $request->locationId)
                    ->get();
        
        $html = '<label for="department_id">Counter<i class="text-danger">*</i></label><br/>
                        <select name="counter_id" class="form-control"
                            onchange="loadUser(this.value)"
                        >
                            <option value="">Select One</option>';


        foreach($counter as $item)
        {
            $html .= '<option value="'. $item->counter->id .'">'. $item->counter->name .'</option>';
        }

        $html .= "</select>";

        return $html;
    }



    public function user(Request $request)
    {
        $users = TokenSetting::with('user')->where('counter_id', $request->counterId)
                    ->get();
        
        $html = '<label for="department_id">Officer<i class="text-danger">*</i></label><br/>
                        <select name="user_id" class="form-control">
                            <option value="">Select One</option>';

        foreach($users as $item)
        {
            $html .= '<option value="'. $item->user->id .'">'. $item->user->firstname . ' ' . $item->user->lastname .'</option>';
        }

        $html .= "</select>";

        return $html;
    }


    public function sendOtp(Request $request)
    {
        $otp = rand(100000, 999999);
        $phone = $request->phone;

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

        $resp = sendSMSByTwilio($phone, "Your One Time Passcode (OTP) is ".$otp." received from Gokiiw");
        
        return response()
                ->json([
                    'success' =>    1,
                    'message'   =>  "OTP Send success",
                    'data'  =>  $resp,
                    'phone' =>  $phone
                ]);
    }


    public function showSingleToken(Request $request)
    {
        if($token = Token::find($request->id))
        {
            // token serial
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

            $data = [];
            $data['apx_time'] = $avgTime . " to " . $nextTime;
            $data['serial'] = ($tokenSerial == 0) ? 'Now your turn' : "<span style='font-size:24px'>" .$tokenSerial . "</span> person left";

            return view('guest.token')->with(compact('data', 'token'));
        }
        else
        {
            return redirect(route('home'));
        }
    
        
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
}
