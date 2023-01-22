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

class UserTypeController extends Controller
{ 
	public function index()
	{   
        $userTypes = UserType::where('company_id', auth()->user()->company_id)->get();

    	return view('backend.admin.user-type.list', compact('userTypes'));
	}



    public function showForm()
    {
        return view('backend.admin.user-type.form');
    }
    
 
    public function create(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone'));
        
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
                UserType::create([ 
                    'company_id'  => auth()->user()->company_id,
                    'name'   => $request->name,
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
        $userType = UserType::find($id); 

        return view('backend.admin.user-type.edit',compact('userType'));
    }


    public function update(Request $request)
    {  
        @date_default_timezone_set(session('app.timezone'));

        $row = UserType::where('id', "!=", $request->id)->where(['name' => $request->name, 'company_id' => auth()->user()->company_id]);

        if ($row->exists())
        {
            return back()
                    ->withInput()
                    ->withErrors(['name' => 'User Type already exists']);
        } else {  

            try{
                UserType::find($request->id)
                ->update([  
                    'name'   => $request->name,
                    'status'      => $request->status,
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
