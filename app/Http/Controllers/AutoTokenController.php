<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Token;
use Illuminate\Http\Request;

class AutoTokenController extends Controller
{
    /**
     * auto token refresh
     */
    public function tokenRefresh(Request $request)
    {
        if(isset($request->token))
        {
            $token = (object)$request->token;

            $runningToken = Token::select(
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

            if($runningToken->status == 1)
            {
                if(!is_null($runningToken->services) AND is_array(json_decode($runningToken->services)) AND count(json_decode($runningToken->services)) > 1)
                {
                    $newToken = Token::select(
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
                                ->where([
                                    'token.token_no'      =>  $runningToken->token_no,
                                    'token.department_id' =>  $runningToken->department_id,
                                    'token.company_id'    =>  $runningToken->company_id,
                                    'token.client_mobile' =>  $runningToken->client_mobile,
                                    'token.status'        => 0
                                ])->latest()->first();

                    if(!is_null($runningToken->services))
                    {
                        $services = Section::whereIn('id', json_decode($runningToken->services))->pluck('name', 'id')->toArray();
                    }

                    $resp = [
                        'title' => companyDetails($runningToken->company_id)->title,
                        'status'    =>  true,
                        'token'   =>  $newToken,
                        'services'  =>  $services ?? null,
                        "HEllo" => "HELOO",
                    ];
                }
                else
                {
                    $resp = [
                        'status'    =>  false,
                        'title' => companyDetails($token->company_id)->title,
                        'token' =>  $token,
                        'message'   =>  "Thank you for staying with us. See you soon"
                    ];
                }
            }
            else
            {
                if(!is_null($token->services))
                {
                    $services = Section::whereIn('id', json_decode($token->services))->pluck('name', 'id')->toArray();
                }

                $resp = [
                    'title' => companyDetails($token->company_id)->title,
                    'status'    =>  true,
                    'services'  =>  $services ?? null,
                    'token'   =>  $token,
                ];
            }

            return response()->json($resp);
        }

        return "request not found";
    }


    public function autoTokenUpdate(Request $request)
    {   
        $token = Token::find($request->id);
        $token->services = json_encode($request->section_id);
        $token->save();

        return back()->with('message', trans('app.save_successfully'));
    }
}
