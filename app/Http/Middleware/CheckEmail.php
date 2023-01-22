<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\RegisterController;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class CheckEmail
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
        if(is_null(Auth::user()->email_verified_at))
        {
            $email = Auth::user()->email;
            $username = Auth::user()->firstname;
            Auth::logout();

            $response = RegisterController::sendVerifyEmail($email, $username);            

            return back()->with('exception', 'We send an email to your email address. Please verify your email to login');
        }

        return $next($request);
    }
}
