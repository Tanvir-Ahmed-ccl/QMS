<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use App\Mail\Subscription;
use App\Models\AppSettings;
use App\Models\Plan;
use App\Models\StripePayment;
use App\Models\User;
use App\Owner;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OwnerController extends Controller
{

    public function loginShow()
    {
        return view('owner.auth.login');
    }


    /** owner login */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:owners,email'],
            'password' => ['required', 'min:6'],
        ]);

        if (Auth::guard('owner')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::guard('owner')->user();
            $email = $request->email;
            $phone = Auth::guard('owner')->user()->phone;
            $password = $request->password;
            $message = "Please check your phone and enter the OTP here...";

            try{
                $otp = rand(100000, 999999);

                if(!is_null($phone)){
                    // send mail
                    Mail::to($email)->send(new OtpEmail(['otp'=>$otp]));

                    //Send otp in mobile
                    sendSMSByTwilio($phone, "Your One Time Passcode (OTP) is ".$otp." received from Gokiiw Owner Panel");
                
                    Owner::find($user->id)->update(['otp'=>$otp]);
                }
            }catch(\Exception $e){                    
                $message = 'Exception Message: '. $e->getMessage();
            }

            Auth::logout();

            return view('owner.auth.login')->with(compact('email', 'password', 'message'));

            // return redirect()->route('owner.dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function otpLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:owners,email'],
            'password' => ['required', 'min:6'],
            'otp' => ['required', 'min:4'],
        ]);

        if (Auth::guard('owner')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::guard('owner')->user();
            $email = $request->email;
            $password = $request->password;
            $message = "OTP Not Matched. Please enter valid OTP";

            if($user->otp == $request->otp)
            {
                return redirect()->route('owner.dashboard');
            }

            Auth::logout();

            return view('owner.auth.login')->with(compact('email', 'password', 'message'));

        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('owner/login');        
    }


    public function dashboard()
    {
        return view('owner.dashboard');
    }


    public function showUsers()
    {
        $users = User::where('user_type', 5)->latest()->paginate(21);

        return view('owner.user.index')->with(compact('users'));
    }

    public function editUser(Request $request)
    {
        $key = $request->key;

        if($row = User::find($key))
        {
            return view('owner.user.edit', compact('row'));
        }

        return back()
                ->with('error', 'User does not exists');
    }



    public function updateUser(Request $request)
    {
        $key = $request->key;

        $request->validate([
            'password'  =>  'nullable|min:8'
        ]);

        if($row = User::find($key))
        {
            $name = explode(" ", $request->name);

            $data = [
                'firstname' =>  trim($name[0]),
                'lastname'  =>  trim($name[1]),
                'email'     =>  $request->email,
                'phone'     =>  $request->phone,
            ];

            if(!empty($request->password))
            {
                $data['password'] = bcrypt($request->password);
            }

            // return $data;

            $row->update($data);

            return redirect(route('owner.users'))
                ->with('success', 'Record updated successfully');
        }

        return back()
                ->with('error', 'User does not exists');
    }




    public function searchUser(Request $request)
    {
        $searchItem = $request->search;

        if(empty($searchItem))
        {
            $users = User::where('user_type', 5)
                ->latest()
                ->paginate(21);
        }
        else
        {
            $users = User::query()->where('user_type', 5);
                
            $users = $users->where('firstname', 'like', "%{$searchItem}%")
                        ->orWhere('lastname', 'like', "%{$searchItem}%")
                        ->orWhere('email', 'like', "%{$searchItem}%")
                        ->latest()
                        ->paginate(21);
        }
        
        return view('owner.user.index', compact('users'));
    }


    public function userSubscription(Request $request, $userId)
    {
        if($user = User::find($userId))
        {
            $plans = Plan::where('status', true)->get();
            return view('owner.user.subscribe')->with(compact('user', 'plans'));
        }
        else
        {
            return back()->with('error', "User does not exists");
        }
    }


    public function updateSubscription(Request $request)
    {
        $userId = $request->key;

        if($user = User::find($userId))
        {
            $plan = Plan::find($request->plan_id);

            $user->subscription_plan = $plan->id;
            $user->subscribe_at = now();
            $user->subscribe_out = Carbon::now()->addDays(30);
            $user->sms_limit += $plan->sms_limit;
            $user->save();

            Mail::to($user->email)->send(new Subscription([
                'subject' => "About Subscription Payment on Gokiiw.net",
                'username' => $user->firstname,
            ]));

            return redirect(url('owner/users'))->with('success', "Plan updated successfully");
        }
        else
        {
            return back()->with('error', "User does not exists");
        }
    }


    public function status(Request $request)
    {
        $key = $request->key;

        if($row = User::find($key))
        {
            if($row->status == 1)
            {
                $row->update(['status' => 2]);
            }
            else if($row->status == 2)
            {
                $row->update(['status' => 1]);
            }

            return back()
                ->with('success', 'Record updated successfully');
        }

        return back()
                ->with('error', 'User does not exists');
    }



    /** ----------  plans control
     * =========================================*/
    public function showPlans()
    {
        $plans = Plan::where('status', true)->get();
    
        return view('owner.plan.index', compact('plans'));
    }

    public function newPlans()
    {
        return view('owner.plan.create');
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'title' =>  'required|string|unique:plans,title',
            'details'   => "required|string",
        ]);

        $data = $request->all();

        Plan::create($data);

        return redirect(route('owner.plans'))->with('success', 'Record created successfully');
    }

    public function editPlans(Request $request)
    {
        $key = $request->key;

        if($plan = Plan::find($key))
        {
            return view('owner.plan.create', compact('plan'));
        }
        
        return back()->with('success', 'Record does not exists');
    }


    public function updatePlans(Request $request)
    {
        $key = $request->key;

        if($plan = Plan::find($key))
        {
            $plan->update($request->all());

            return redirect(route('owner.plans'))->with('success', 'Record updated successfully');
        }
        
        return back()->with('error', 'Record does not exists');
    }

    public function deletePlan(Request $request)
    {
        $key = $request->key;

        if($plan = Plan::find($key))
        {
            $plan->delete();

            return redirect(route('owner.plans'))->with('success', 'Record deleted successfully');
        }
        
        return back()->with('error', 'Record does not exists');
    }

    public function stripe()
    {
        $payments = StripePayment::where('is_delete', 0)->latest()->get();
        
        return view('owner.stripe')->with(compact('payments'));
    }


    public function showAppSettings(Request $request, $what = null)
    {
       return view('owner.app_settings')->with(compact('what'));
    }

    public function showAbout()
    {
        return view('owner.about');
    }


    public function storeAbout(Request $request)
    {
        $about = $request->input('about_us');
    
        $row = AppSettings::find(1);
        $row->ABOUT_US_ONE = $about;
        $row->save();

        return back()->with('success', 'Record updated successfully');
    }

    public function appSettings(Request $request)
    {
        $row = AppSettings::find(1);

        $data = $request->all();

        if($request->has('APP_LOGO'))
        {
            $request->validate([
                'APP_LOGO' => 'file|mimes:png,jpg,jpeg,svg|max:1024',
            ]);

            $APP_LOGO = uniqid(). '.' .$request->APP_LOGO->extension();
            // save into folder
            $request->APP_LOGO->move(public_path('images'), $APP_LOGO);

            // save into database
            $data['APP_LOGO'] = 'images/'. $APP_LOGO;
        }

        if($row->update($data))
        {
            Artisan::call('cache:clear');
            return back()->with('success', 'Record updated successfully');
        }

        return back()->with('error', 'Failed to process. Please try again');

    }

    public function showProfile()
    {
        return view('owner.profile');
    }

    public function updateProfile(Request $request)
    {
        Owner::find($request->update_key)->update($request->all());
        return back();
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password'  =>  'required|min:8|confirmed'
        ]);

        $row = Owner::find($request->update_key);

        if(Hash::check($request->current_password, $row->password))
        {
            $row->update(['password' => bcrypt($request->password)]);
            return back()->with('success', 'Record Updated successfully');
        }
        
        return back()->with('error', 'Password not matched');
    }


    public function ownerList()
    {
        $owners = Owner::where('id', '!=', auth()->guard('owner')->id())->latest()->paginate(20);

        return view('owner.owners.index')->with(compact('owners'));
    }

    public function ownerCreate(Request $request)
    {
        if(is_null($request->rowId))
        {
            return view('owner.owners.edit');
        }
        else
        {
            if($row = Owner::find($request->rowId))
            {
                return view('owner.owners.edit')->with(compact('row'));
            }
        }
    }


    public function ownerStore(Request $request)
    {
        $request->validate([
            'name'  =>  'required',
            'email' =>  'required|unique:owners,email',
            'password'  =>  'required'
        ]);

        Owner::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'  =>  bcrypt($request->password)
        ]);

        return redirect(route('owners'))->with('success', 'Record added successfully');
    }


    public function ownerUpdate(Request $request)
    {
        $data = [
            'name'  =>  $request->name,
            'email' =>  $request->email
        ];

        if(!empty($request->password))
        {
            $data['password'] = bcrypt($request->password);
        }

        Owner::find($request->key)->update($data);

        return redirect(route('owners'))->with('success', 'Record added successfully');
    }


    public function ownerDelete(Request $request)
    {
        $key = $request->key;

        if($row = Owner::find($key))
        {
            $row->delete();

            return redirect(route('owners'))->with('success', 'Record deleted successfully');
        }
        return redirect(route('owners'))->with('error', 'Record deleted successfully');
    }



    public function ownerStatus(Request $request)
    {
        $key = $request->key;

        if($row = Owner::find($key))
        {
            if($row->status == 1)
            {
                $row->update(['status' => 0]);
            }
            else
            {
                $row->update(['status' => 1]);
            }

            return back()
                ->with('success', 'Record updated successfully');
        }

        return back()
                ->with('error', 'Record does not exists');
    }



    /**
     * terms of service
     */
    public function showTerms()
    {
        $terms = AppSettings::first()->terms;

        return view('owner.terms', compact('terms'));
    }


    /**
     * update terms of service
     */
    public function updateTerms(Request $request)
    {
        try{
            AppSettings::first()->update([
                "terms" =>  $request->terms
            ]);

            return back()->with('success', 'Record updated successfully');
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }
}
