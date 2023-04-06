<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ads'] = Ads::selfData();

        return view('ads.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ads.form');
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
            'title' =>  'required|string',
            'link' =>  'required|string',
            'banner' =>  'required|file|mimes:png,jpg,jpeg,gif',
        ]);

        $ads = new Ads();
        $ads->company_id = getCompanyDetails(Auth::id())->company_id;
        $ads->title = $request['title'];
        $ads->link = $request['link'];
        if($request->has('banner'))
        {
            $fileName = date('hisdmy') . '.' .$request->file('banner')->extension();
            $request->file('banner')->move(public_path('upload/ads'), $fileName);
            $ads->images = "upload/ads/" . $fileName;
        }
        $ads->save();

        return redirect()->route('advertisement.index');
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
        if($ads = Ads::find($id))
        {
            return view('ads.form', compact('ads'));
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' =>  'required|string',
            'link' =>  'required|string',
            'banner' =>  'nullable|file|mimes:png,jpg,jpeg,gif',
        ]);

        $ads = Ads::find($id);
        $ads->title = $request['title'];
        $ads->link = $request['link'];
        if($request->has('banner'))
        {
            File::delete(public_path($ads->images));

            $fileName = time() . '.' .$request->file('banner')->getExtension();
            $request->file('banner')->move(public_path('upload/ads'), $fileName);
            $ads->images = "upload/ads/" . $fileName;
        }
        $ads->save();

        return redirect()->route('addon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($ads = Ads::find($id))
        {
            $ads->delete();

            return back();
        }

        return back();
    }
}
