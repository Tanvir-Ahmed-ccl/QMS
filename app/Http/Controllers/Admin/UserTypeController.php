<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Http\Requests; 
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Token;
use App\Models\Department;
use App\Models\UserType;
use DB, Hash, Image, Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserTypeController extends Controller
{ 
	public function index()
	{
        if(issetAccess(Auth::user()->user_role_id)->user_type['read'] == false) // Unless the user has access
        {
            return redirect('login')->with('exception',trans('app.you_are_not_authorized'));
        }

        $userTypes = UserType::where('company_id', auth()->user()->company_id)->get();

    	return view('backend.admin.user-type.list', compact('userTypes'));
	}


    public function showForm()
    {   
        if(issetAccess(Auth::user()->user_role_id)->user_type['write'] == false) // Unless the user has access
        {
            return redirect('login')->with('exception',trans('app.you_are_not_authorized'));
        }

        return view('backend.admin.user-type.form');
    }
    
 
    public function create(Request $request)
    { 
        // return $request;

        if(issetAccess(Auth::user()->user_role_id)->user_type['write'] == false) // Unless the user has access
        {
            return redirect('login')->with('exception',trans('app.you_are_not_authorized'));
        }

        @date_default_timezone_set(session('app.timezone'));

        // return $request;
        
        $row = UserType::where(['name' => $request->name, 'company_id' => auth()->user()->company_id]);

        if ($row->exists())
        {
            return back()
                    ->withInput()
                    ->withErrors(['name' => 'User Type already exists']);
                    // ->with('exception', 'User Type already exists');
        }
        else 
        {
        	try{

                $userAccess = [
                    "location" => [
                        "read"  =>  $request->location_read ?? 0,
                        "write"  => $request->location_write ?? 0,
                    ],
                    "section" => [
                        "read"  =>  $request->section_read ?? 0,
                        "write"  => $request->section_write ?? 0,
                    ],
                    "counter" => [
                        "read"  =>  $request->counter_read ?? 0,
                        "write"  => $request->counter_write ?? 0,
                    ],
                    "user_type" => [
                        "read"  =>  $request->user_type_read ?? 0,
                        "write"  => $request->user_type_write ?? 0,
                    ],
                    "users" => [
                        "read"  =>  $request->users_read ?? 0,
                        "write"  => $request->users_write ?? 0,
                    ],
                    "sms" => [
                        "read"  =>  $request->sms_read ?? 0,
                        "write"  => $request->sms_write ?? 0,
                    ],
                    "token" => [
                        "auto_token"    => $request->token_auto_token ?? 0,
                        "manual_token"    => $request->token_manual_token ?? 0,
                        "active_token"    => [
                            'own_token'  =>  $request->token_active_token_own ?? 0,
                            'all_token' =>  $request->token_active_token_all ?? 0,
                            // 'read'  =>  $request->token_active_token_write ?? 0,
                            // 'write' =>  $request->token_token_report_read ?? 0,
                        ],
                        "token_report"    => [
                            'read'  =>  $request->token_token_report_read ?? 0,
                            'write' =>  $request->token_token_report_write ?? 0,
                        ],
                        "performance_report"    => $request->token_performance_report ?? 0,
                        "auto_token_setting"    => $request->token_auto_token_setting ?? 0,
                    ],
                    "display"   =>  $request->display ?? 0,
                    "message"   =>  $request->message ?? 0,
                    "admin_dashboard"   =>  $request->admin_dashboard ?? 0,
                    "setting"   =>  [
                        'app_setting'   =>  $request->setting_app_setting ?? 0,
                        'subsription'   =>  $request->setting_subsription ?? 0,
                        'display_setting'   =>  $request->setting_display_setting ?? 0,
                        'profile_information'   =>  $request->setting_profile_information ?? 0,
                    ]
                ];

                UserType::create([ 
                    'company_id'  => auth()->user()->company_id,
                    'name'   => $request->name,
                    'roles'     => json_encode($userAccess),
                    'status'      => $request->status,
                ]);

                return back()->with('message',trans('app.save_successfully'));
            }
            catch(Exception $e)
            {
                $msg =  $e->getMessage();
            }

            return back()
                    ->withInput()
                    ->with('exception', $msg);

        }
    }


    public function view($id = null)
    {
        $user = User::select(
                'user.*', 
                'department.name as department'
            )->leftJoin('department', 'user.department_id', '=', 'department.id')
            ->where('user.id', $id)
            ->first(); 

        // assigned to me {as a officer}
        $assignedToMe = Token::where('user_id', $id)
            ->selectRaw("COUNT(id) as total, status")
            ->groupBy('status')
            ->pluck("total", "status");

        // created by me {as a admin/client/reciptionist}
        $generatedByMe = Token::where('created_by', $id)
            ->selectRaw("COUNT(id) as total, status")
            ->groupBy('status')
            ->pluck("total", "status");

        // my token { mobile number as client}
        $myToken = Token::where('client_mobile', $user->mobile)
            ->selectRaw("COUNT(id) as total, status")
            ->groupBy('status')
            ->pluck("total", "status"); 

        return view('backend.admin.user.view', compact(
            'user',
            'assignedToMe',
            'generatedByMe',
            'myToken'
        ));
    }

 
    public function showEditForm($id = null)
    {
        if(issetAccess(Auth::user()->user_role_id)->user_type['write'] == false) // Unless the user has access
        {
            return redirect('login')->with('exception',trans('app.you_are_not_authorized'));
        }

        $userType = UserType::find($id); 

        return view('backend.admin.user-type.edit',compact('userType'));
    }


    public function update(Request $request)
    {  
        // return $request;
        if(issetAccess(Auth::user()->user_role_id)->user_type['write'] == false) // Unless the user has access
        {
            return redirect('login')->with('exception',trans('app.you_are_not_authorized'));
        }

        @date_default_timezone_set(session('app.timezone'));

        $row = UserType::where('id', "!=", $request->id)->where(['name' => $request->name, 'company_id' => auth()->user()->company_id]);

        if ($row->exists())
        {
            return back()
                    ->withInput()
                    ->withErrors(['name' => 'User Type already exists']);
        } else {  

            try{

                
                $userAccess = [
                    "location" => [
                        "read"  =>  $request->location_read ?? 0,
                        "write"  => $request->location_write ?? 0,
                    ],
                    "section" => [
                        "read"  =>  $request->section_read ?? 0,
                        "write"  => $request->section_write ?? 0,
                    ],
                    "counter" => [
                        "read"  =>  $request->counter_read ?? 0,
                        "write"  => $request->counter_write ?? 0,
                    ],
                    "user_type" => [
                        "read"  =>  $request->user_type_read ?? 0,
                        "write"  => $request->user_type_write ?? 0,
                    ],
                    "users" => [
                        "read"  =>  $request->users_read ?? 0,
                        "write"  => $request->users_write ?? 0,
                    ],
                    "sms" => [
                        "read"  =>  $request->sms_read ?? 0,
                        "write"  => $request->sms_write ?? 0,
                    ],
                    "token" => [
                        "auto_token"    => $request->token_auto_token ?? 0,
                        "manual_token"    => $request->token_manual_token ?? 0,
                        "active_token"    => [
                            'own_token'  =>  $request->token_active_token_own ?? 0,
                            'all_token' =>  $request->token_active_token_all ?? 0,
                            // 'read'  =>  $request->token_active_token_read ?? 0,
                            // 'write' =>  $request->token_active_token_write ?? 0,
                        ],
                        "token_report"    => [
                            'read'  =>  $request->token_token_report_read ?? 0,
                            'write' =>  $request->token_token_report_write ?? 0,
                        ],
                        "performance_report"    => $request->token_performance_report ?? 0,
                        "auto_token_setting"    => $request->token_auto_token_setting ?? 0,
                    ],
                    "display"   =>  $request->display ?? 0,
                    "message"   =>  $request->message ?? 0,
                    "admin_dashboard"   =>  $request->admin_dashboard ?? 0,
                    "setting"   =>  [
                        'app_setting'   =>  $request->setting_app_setting ?? 0,
                        'subsription'   =>  $request->setting_subsription ?? 0,
                        'display_setting'   =>  $request->setting_display_setting ?? 0,
                        'profile_information'   =>  $request->setting_profile_information ?? 0,
                    ]
                ];


                UserType::find($request->id)
                ->update([
                    'name'   => $request->name,
                    'status'      => $request->status,
                    'roles' =>  json_encode($userAccess)
                ]);

                return back()->with('message', trans('app.update_successfully'));
            }
            catch(Exception $e)
            {
                $msg = $e->getMessage();
            }

            return back()
                    ->withInput()
                    ->with('exception', $msg);

        }
    }
 
    public function delete($id = null)
    {
        if(issetAccess(Auth::user()->user_role_id)->user_type['write'] == false) // Unless the user has access
        {
            return redirect('login')->with('exception',trans('app.you_are_not_authorized'));
        }

        $msg = '';

        try{
            UserType::destroy($id);

            return back()
                    ->with('message', trans('app.delete_successfully'));
        }
        catch(Exception $e)
        {
            $msg = $e->getMessage();
        }

        return back()
                    ->with('exception', $msg);
    } 

}
