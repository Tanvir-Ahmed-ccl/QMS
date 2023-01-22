<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests; 
use App\Models\Counter;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Validator, App;

class SectionController extends Controller
{
	public function index()
	{   
        $sections = Section::with('department')->where('company_id', auth()->user()->company_id)->get();
    	return view('backend.admin.section.list', ['sections' => $sections]);
	}

    public function showForm()
    {
        $departments = Department::where('company_id', auth()->user()->company_id)->get(['id','name']);
    	return view('backend.admin.section.form', compact('departments'));
    }
    
    public function create(Request $request)
    {     
        @date_default_timezone_set(session('app.timezone'));
        
        $validator = Validator::make($request->all(), [ 
            'status'      => 'required',
            'name'        => 'required|max:50',
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'status' => trans('app.status'),
        ));

        if ($validator->fails()) {
            return redirect('admin/section/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $companyId = Auth::user()->company_id;

            if(Section::where(['company_id' => $companyId, 'name' => $request->name])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'section is already exists'])
                ->withInput();
            }
 
            $save = Section::insert([
                'company_id'  => auth()->user()->company_id,
                'name'        => $request->name,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => now(),
                'status'      => $request->status
            ]);

        	if ($save) {
	            return back()->withInput()
                        ->with('message', trans('app.save_successfully'));
        	} else {
	            return back()->withInput()
                        ->with('exception', trans('app.please_try_again'));
        	}

        }
    }
 
    public function showEditForm($id = null)
    {
        $section = Section::find($id);
        return view('backend.admin.counter.edit', compact('section'));
    }
  
    public function update(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone')); 

        $validator = Validator::make($request->all(), [ 
            'status'      => 'required',
            'name'        => 'required|max:50|unique:sections,name,'.$request->id,
        ])
        ->setAttributeNames(array(
           'name' => trans('Already Exists'),
           'status' => trans('app.status')
        ));

        if ($validator->fails()) {
            return redirect('admin/section/edit/'.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $companyId = Auth::user()->company_id;

            if(Section::where(['company_id' => $companyId, 'name' => $request->name])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'Section is already exists'])
                ->withInput();
            }

            $update = Section::where('id',$request->id)->update([
                    'name'        => $request->name,
                    'updated_at'  => date('Y-m-d H:i:s'),
                    'status'      => $request->status
                ]);

            if ($update) {
                return back()
                        ->with('message', trans('app.update_successfully'));
            } else {
                return back()
                        ->with('exception', trans('app.please_try_again'));
            }

        }
    }
 
    public function delete($id = null)
    {
        $delete = Section::where('id', $id)
            ->delete();
        return redirect('admin/section')->with('message', trans('app.delete_successfully'));
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
