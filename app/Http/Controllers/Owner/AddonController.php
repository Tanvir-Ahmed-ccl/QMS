<?php

namespace App\Http\Controllers\Owner;

use App\Addon;
use App\Http\Controllers\Controller;
use App\Slider;
use Exception;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Addon::get();

        return view('owner.addon.index')->with(compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($row = Addon::find($id))
        {
            return view('owner.addon.form', compact('row'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        if($addon = Addon::find($request->addonId))
        {
            $addon->title = $request->title;
            $addon->price = $request->price;
            $addon->limitation = $request->limitation;
            $addon->description = $request->description;
            $addon->save();

            return redirect(route('addon.index'))->with('success', 'Updated Successfully');
        }

        return back()->with('error', 'Something went wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Slider::destroy($id);

            return back();
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }
}
