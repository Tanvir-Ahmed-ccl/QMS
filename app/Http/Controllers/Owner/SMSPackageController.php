<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\SMSPackage;
use Exception;
use Illuminate\Http\Request;

class SMSPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['plans'] = SMSPackage::all();

        return view('owner.sms.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.sms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'unique:s_m_s_packages,title'],
            'price' => ['required'],
            'sms_limit' => ['required', 'integer'],
        ]);

        try{
            SMSPackage::create($request->only(['title', 'description', 'price', 'sms_limit']));
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('sms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SMSPackage  $sMSPackage
     * @return \Illuminate\Http\Response
     */
    public function show(SMSPackage $sMSPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SMSPackage  $sMSPackage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = SMSPackage::find($id);

        return view('owner.sms.create', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SMSPackage  $sMSPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SMSPackage $sMSPackage)
    {
        $request->validate([
            'title' => ['required', 'unique:s_m_s_packages,title,'.$request['key'].',id'],
            'price' => ['required'],
            'sms_limit' => ['required', 'integer'],
        ]);

        try{
            SMSPackage::find($request['key'])->update($request->only(['title', 'description', 'price', 'sms_limit']));
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('sms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SMSPackage  $SMSPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SMSPackage::destroy($id);
        return back();
    }
}
