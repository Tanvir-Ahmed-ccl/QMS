<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller{
    
    use ApiResponses;

    /** ------------    Api Login
     * =================================================*/
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  ['required', 'email', 'exists:users'],
            "password"=>    ['required', 'min:8']
        ]);

        if($validator->fails())
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }


        if(Auth::attempt($request->only(['email', 'password'])))
        {
            $user = Auth::user();

            $token = $user->createToken($user->firstname)->plainTextToken;

            $data = [
                'bearerToken'  =>  $token,
                'user'         =>  [
                    'userId'    =>  $user->id,
                    'firstName' =>  $user->firstname,
                    'lastName'  =>  $user->lastname,
                    'email'     =>  $user->email,
                    'mobile'    =>  $user->mobile,
                    'companyId'   =>  $user->company_id,
                    'companyName'   =>  $user->setting->title,
                ]
            ];

            return $this->success($data, 'Credantial matched successfully');
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
            "firstname" =>  ['required', 'string'],
            "lastname" =>  ['required', 'string'],
            "email" =>  ['required', 'email', 'unique:users'],
            "mobile" =>  ['required',    'unique:users'],
            "password"=>    ['required', 'min:8']
        ]);

        if($validator->fails())
        {
            $message = $validator->errors()->first();
            return $this->error($message);
        }

    }


}