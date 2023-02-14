<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ApiResponses;

    public function index(Request $request, $userId)
    {
        $user = User::find($userId);

        $infoBox = $this->infoBox($user->company_id);

        $resp = [
            'countBox'  =>  $infoBox
        ];

        return $this->success($resp, 'Data Fetched successully');
    }


    public function infoBox($companyId)
    {
        $infoBox = array();
        $infoBox['locations'] = DB::table('department')->where('company_id', $companyId)->count();
        $infoBox['sections'] = DB::table('sections')->where('company_id', $companyId)->count();
        $infoBox['counters'] = DB::table('counter')->where('company_id', $companyId)->count();
        $infoBox['users'] = DB::table('user')->where('company_id', $companyId)->count();
        $infoBox['tokens'] = DB::table('token')
                            ->select(DB::raw("
                                COUNT(CASE WHEN STATUS = '0' THEN id END) AS pending,
                                COUNT(CASE WHEN STATUS = '1' THEN id END) AS accepted,
                                COUNT(CASE WHEN STATUS = '2' THEN id END) AS stopped,
                                COUNT(id) AS total
                            "))
                            ->where('company_id', $companyId)
                            ->first();

        return $infoBox;
    }
}