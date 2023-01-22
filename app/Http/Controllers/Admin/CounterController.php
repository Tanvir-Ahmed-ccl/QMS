<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests; 
use App\Models\Counter;
use Illuminate\Support\Facades\Auth;
use Validator, App;

class CounterController extends Controller
{
	public function index()
	{   
        $counters = Counter::where('company_id', auth()->user()->company_id)->get();
    	return view('backend.admin.counter.list', ['counters' => $counters]);
	}

    public function showForm()
    {
        $keyList = $this->keyList();
    	return view('backend.admin.counter.form', compact('keyList'));
    }
    
    public function create(Request $request)
    {     
        @date_default_timezone_set(session('app.timezone'));
        
        $validator = Validator::make($request->all(), [ 
            'description' => 'max:255',
            'status'      => 'required',
            'name'        => 'required|max:50',
            'key'        => 'required|max:1',
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'description' => trans('app.description'),
           'status' => trans('app.status'),
           'key' => trans('app.key_for_keyboard_mode'),
        ));

        if ($validator->fails()) {
            return redirect('admin/counter/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $companyId = Auth::user()->company_id;

            if(Counter::where(['company_id' => $companyId, 'name' => $request->name])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'Counter is already exists'])
                ->withInput();
            }

            if(Counter::where(['company_id' => $companyId, 'key' => $request->key])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'This key is already exists'])
                ->withInput();
            }
 
            $save = Counter::insert([
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
                        ->with('message', trans('app.save_successfully'));
        	} else {
	            return back()->withInput()
                        ->with('exception', trans('app.please_try_again'));
        	}

        }
    }
 
    public function showEditForm($id = null)
    {
        $counter = Counter::where('id', $id)->first();
        $keyList = $this->keyList();
        return view('backend.admin.counter.edit', compact('counter', 'keyList'));
    }
  
    public function update(Request $request)
    { 
        @date_default_timezone_set(session('app.timezone')); 

        $validator = Validator::make($request->all(), [ 
            'description' => 'max:255',
            'status'      => 'required',
            'name'        => 'required|max:50|unique:counter,name,'.$request->id,
        ])
        ->setAttributeNames(array(
           'name' => trans('app.name'),
           'description' => trans('app.description'),
           'status' => trans('app.status')
        ));

        if ($validator->fails()) {
            return redirect('admin/counter/edit/'.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $companyId = Auth::user()->company_id;

            if(Counter::where('id', "!=", $request->id)->where(['company_id' => $companyId, 'name' => $request->name])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'Counter is already exists'])
                ->withInput();
            }

            if(Counter::where('id', '!=' ,$request->id)->where(['company_id' => $companyId, 'key' => $request->key])->exists())
            {
                return redirect('admin/department/create')
                ->withErrors(['name' => 'This key is already exists'])
                ->withInput();
            }

            $update = Counter::where('id',$request->id)->update([
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
                        ->with('exception', trans('app.please_try_again'));
            }

        }
    }
 
    public function delete($id = null)
    {
        $delete = Counter::where('id', $id)
            ->delete();
        return redirect('admin/counter')->with('message', trans('app.delete_successfully'));
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
