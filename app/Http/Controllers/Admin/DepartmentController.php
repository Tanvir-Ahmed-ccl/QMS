<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    
    public function index()
    { 
        $departments = Department::where('company_id', auth()->user()->company_id)->get();
        return view('backend.admin.department.list', compact('departments'));
    }

    public function showForm()
    {
        $keyList = $this->keyList();
        return view('backend.admin.department.form', compact('keyList'));
    }
    
    /**---------------  Store Department
     * =============================================*/
    public function create(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone'));

        $companyId = Auth::user()->company_id;

        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
            'description' => 'max:255',
            'key'         => 'required|max:1',
            'status'      => 'required',
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'description' => trans('app.description'),
           'key' => trans('app.key_for_keyboard_mode'),
           'status' => trans('app.status')
        ));

        if ($validator->fails()) {
            return redirect('admin/department/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            if(Department::where(['company_id' => $companyId, 'name' => $request->name])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'Department is already exists'])
                ->withInput();
            }
            else if(Department::where(['company_id' => $companyId, 'key' => $request->key])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['key' => 'This key is already exists'])
                ->withInput();
            }
            

            $save = Department::insert([
                'company_id'  => auth()->user()->company_id,
                'name'        => $request->name,
                'description' => $request->description,
                'key'         => $request->key,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => null,
                'status'      => $request->status
            ]);

            if ($save) {
                return back()->withInput()
                        ->with('message',trans('app.save_successfully'));
            } else {
                return back()->withInput()
                        ->with('exception', trans('app.please_try_again'));
            }

        }
    } 
 
    public function showEditForm($id = null)
    {
        $keyList = $this->keyList();
        $department = Department::where('id', $id)->first();
        return view('backend.admin.department.edit', compact('department', 'keyList'));
    }


    public function update(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone'));

        $companyId = Auth::user()->company_id;

        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
            'description' => 'max:255',
            'key'         => 'required|max:1',
            'status'      => 'required',
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'description' => trans('app.description'),
            'key' => trans('app.key_for_keyboard_mode'),
           'status' => trans('app.status')
        ));

        if ($validator->fails()) {
            return redirect('admin/department/edit/'.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            if(Department::where('id', "!=", $request->id)->where(['company_id' => $companyId, 'name' => $request->name])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'Department is already exists'])
                ->withInput();
            }
            else if(Department::where('id', "!=", $request->id)->where(['company_id' => $companyId, 'key' => $request->key])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['key' => 'This key is already exists'])
                ->withInput();
            }

            $update = Department::where('id',$request->id)
                ->update([
                    'name'        => $request->name,
                    'description' => $request->description,
                    'key'         => $request->key,
                    'updated_at'  => date('Y-m-d H:i:s'),
                    'status'      => $request->status
                ]);

            if ($update) {
                return back()
                        ->with('message', trans('app.update_successfully'));
            } else {
                return back()
                        ->with('exception',trans('app.please_try_again'));
            }

        }
    }
 
    public function delete($id = null)
    {
        $delete = Department::where('id', $id)->delete();
        return redirect('admin/department')->with('message', trans('app.delete_successfully'));
    } 
 
    public function keyList()
    {
        $chars = array_merge(range('1','9'), range('a','z'));
        $list = array();
        foreach($chars as $char)
        {
            if ($char != "v")
            $list[$char] = $char;
        }
        return $list;
    }
 
}
