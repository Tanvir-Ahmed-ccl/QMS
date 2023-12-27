<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::fallback(function(){
    return "Api does not exists. Please check the api endpoint";
});

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




/** --------------- Route For Customer Auth
 * ============================================*/
Route::namespace("Api\Auth")
->group(function(){

    Route::post("customer/login", "CustomerAuthController@login");
    Route::post("customer/signup", "CustomerAuthController@register");
    Route::post("customer/otp", "CustomerAuthController@checkOtpAndLogin");

});


/** --------------- Route For Remote Queue Login
 * ============================================*/
Route::namespace("Api\RemoteQueue")
->group(function(){

    Route::post("remote-queue/login", "RemoteQueueController@remoteQueueLogin");

});



/** --------------- route fallback
 * ===========================================*/
Route::any('{any}', function(){
    return response()->json([
        'status'    =>  false,
        'message'   =>  "Api does not exists",
    ], 404);
})->where('any', '.*');