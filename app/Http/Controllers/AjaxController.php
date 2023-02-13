<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\TokenSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function counter(Request $request)
    {
        $counter = TokenSetting::where('department_id', $request->locationId)
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
        $token = Token::find($request->id);
    
        return view('guest.token')->with(compact('token'));
    }
}
