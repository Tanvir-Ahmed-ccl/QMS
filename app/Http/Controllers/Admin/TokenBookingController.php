<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Department;
use App\Models\DisplaySetting;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Token;
use App\Models\TokenSetting;
use App\Models\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TokenBookingController extends Controller
{

    public function showSetting()
    {
        $time = DB::table('addon_settings')
        ->where([
            'addon_id'  => 1,
            'company_id'    => getCompanyDetails(Auth::id())->id,
        ]);

        if($time->exists())
        {
            $time = $time->first(['before_time_alert as time']);
            return view('backend.admin.book.settings', compact('time'));
        }
        else
        {
            return view('backend.admin.book.settings');
        }
    }


    public function setting(Request $request)
    {
        DB::table('addon_settings')->updateOrInsert(
            [
                'addon_id'  => 1,
                'company_id'    => getCompanyDetails(Auth::id())->id,
            ],
            [
                'before_time_alert' => $request->time,
                'created_at'    => now()
            ],
        );

        return redirect()->route('book.index');
    }




    public function index()
    {
        @date_default_timezone_set(session('app.timezone'));

        $tokens = Token::whereHas('department', function($q)
        {
            $q->where('company_id', auth()->user()->company_id);
        })
        ->where('status', '0')
        ->where('created_at', '>', date('Y-m-d H:i:m', strtotime(\Carbon\Carbon::now()->addMinutes(5))))
        ->orderBy('is_vip', 'DESC')
        ->orderBy('id', 'ASC')
        ->get();        

        $counters = Counter::where('company_id', auth()->user()->company_id)->where('status',1)->pluck('name','id');
        $departments = Department::where('company_id', auth()->user()->company_id)->where('status',1)->pluck('name','id');
        $officers = User::select(DB::raw('CONCAT(firstname, " ", lastname) as name'), 'id')
            ->where('company_id', auth()->user()->company_id)
            ->where('user_type',1)
            ->where('status',1)
            ->orderBy('firstname', 'ASC')
            ->pluck('name', 'id');

        return view('backend.admin.book.list')->with(compact('counters', 'departments', 'officers', 'tokens'));
    }


    
}
