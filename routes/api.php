<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/** --------------- Route For Auth
 * ============================================*/
Route::namespace("Api\Auth")
->group(function(){

    Route::post("login", "AuthController@login");
    Route::post("signup", "AuthController@register");
    Route::post("check-otp", "AuthController@checkOtpAndLogin");

});



/** ---------   Protected Api
 * ============================================*/
Route::prefix('{userId}')
->group(function(){

    Route::get('home', 'Api\HomeController@index');

});