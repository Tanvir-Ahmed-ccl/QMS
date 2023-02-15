<?php
namespace App\Http\Controllers\Admin;

use App\Addon;
use App\AddonUsesHistory;
use App\Http\Controllers\Controller;
use App\Models\AppSettings;
use App\Models\StripePayment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Class AddonController extends Controller
{
    public function index()
    {
        $rows = Addon::where('active', true)->get();
        return view('backend.admin.addon.list', compact('rows'));
    }


    /**
     *  Addon Purchase
     */
    public function purchase(Request $request)
    {
        // return $request;
        $USER_KEY = Auth::id();
        $addon = Addon::find($request->addon_id);

        try{
            \Stripe\Stripe::setApiKey(\App\Models\AppSettings::first()->STRIPE_SECRET);

            $res = \Stripe\Charge::create([
                        "amount"    => $request->amount * 100,
                        "currency"  => AppSettings::first()->CURRENCY_CODE,
                        "source"    => $request->stripeToken,
                        "description" => "Payment for subscription from contentforms.com.",
                    ]);
        }catch(Exception $e){
            return back()->with('info', $e->getMessage());
        }
        
        if($res->status == 'succeeded')
        {
            $insert = new StripePayment();
            $insert->user_id = $USER_KEY;
            $insert->stripe_id = $res->id;
            $insert->amount = $res->amount;
            $insert->amount_captured = $res->amount_captured;
            $insert->amount_refunded = $res->amount_refunded;
            $insert->application_fee = $res->application_fee;
            $insert->application_fee_amount = $res->application_fee_amount;
            $insert->balance_transaction = $res->balance_transaction;
            $insert->currency = $res->currency;
            $insert->description = $res->description;
            $insert->payment_method = $res->payment_method;
            $insert->status = $res->status;

            if($insert->save())
            {
                AddonUsesHistory::insert([
                    'user_id'   => Auth::id(),
                    'addon_id'  =>  $addon->id,
                    'purchase_at'   =>  now(),
                    'purchase_out'  =>  \Carbon\Carbon::now()->addDays($addon->limitation),
                    'stripe_payments_id'  =>  $insert->id,
                    'status'  =>  $insert->id,
                    'created_at'  =>  now(),
                    'updated_at'  =>  now(),
                ]);

                return back()->with('success', 'Payment successful!');
            }

            return back()->with('success', 'Payment received successfully');
        }

        return back()->with('error', 'Failed to received payment. Please try again');
    }

}
