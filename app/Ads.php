<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ads extends Model
{
    protected $guarded = [];

    public static function selfData($cid=null)
    {
        if(\App\AddonUsesHistory::where('user_id', companyOwner($cid)->id)->where('addon_id', 3)->exists()):
            if(is_null($cid)):
            return Ads::where('company_id', getCompanyDetails(Auth::user()->company_id)->company_id)->get();
            else:
            return Ads::where('company_id', companyOwner($cid)->id)->get();
            endif;
        else:
            return [];
        endif;


        
    }
}
