<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check())
        {
            $companyId = Auth::user()->company->company_id;
            $company = User::find($companyId);
            $toDate = Carbon::parse(now());
            $fromDate = Carbon::parse($company->created_at);
            $days = $toDate->diffInDays($fromDate);

            if($days >= 14)
            {
                if(is_null($company->subscribe_out))
                {
                    return redirect('/admin/subscription');
                }
                else
                {
                    
                    if($company->subscribe_out <= now())
                    {
                        $company->update([
                            // "subscription_plan" => null,
                            "subscribe_at" => null,
                            "subscribe_out" => null,
                        ]);
                        return redirect('/admin/subscription');
                    }
                }
            }            
        }

        return $next($request);
    }
}
