@extends('layouts.backend')
@section('title', trans('app.app_setting'))

@section('content')

@if (isset($currentPlan))
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 text-left">
                <h3>Your Running Plan</h3>
            </div> 
        </div>
    </div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-sm-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h2 class="fw-bolder"><b>{{ $currentPlan->title }}</b></h2>
                            <h2 class="fw-bolder">{{\App\Models\AppSettings::first()->CURRENCY_SIGN}} {{ $currentPlan->price_per_month }} <small>/mo</small></h2>
                        </div>
                        <div class="my-4">
                            <h5>
                                SMS Limit exists: {{ $smsLimit }}
                            </h5>

                            <button class="btn btn-sm btn-danger" style="font-size: 20px">
                                Left Days: {{ (\Carbon\Carbon::parse(now())->gt(\Carbon\Carbon::parse(Auth::user()->company->subscribe_out))) ? "Over" : $daysDiff }}
                            </button>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endif

@if (isset($trialDays))
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 text-left">
                <h3>Your Running Plan</h3>
            </div> 
        </div>
    </div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-sm-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h2 class="fw-bolder"><b>14 days trial mode</b></h2>
                        </div>
                        <div class="my-4">
                            <h5>
                                SMS Limit exists: Unlimited
                            </h5>

                            <button class="btn btn-sm btn-danger">
                                Left Days: {{ ($trialDays <= 0) ? "Over" : $trialDays}}
                            </button>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endif

<div class="panel panel-primary" id="printMe">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 text-left">
                <h3>Select the best plan for you</h3>
            </div> 
        </div>
    </div>    

    <div class="panel-body"> 
        <div class="row">
            @foreach ($plans as $item)
            <div class="col-sm-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="fw-bolder">{{ $item->title }}</h5>
                            <h2 class="fw-bolder">{{\App\Models\AppSettings::first()->CURRENCY_SIGN}} {{ $item->price_per_month }} <small>/mo</small></h2>
                        </div>
                        <div class="my-4">
                            {!! $item->details !!}
                        </div>
                        
                        <div class="">
                            <form action="{{ route('stripe.payment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $item->id }}">
                                <input type="hidden" name="amount" value="{{ $item->price_per_month }}">
                                <script 
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key = "{{ App\Models\AppSettings::first()->STRIPE_KEY }}"
                                    data-amount="{{__($item->price_per_month * 100)}}"
                                    data-name="{{ \App\Models\AppSettings::first()->APP_NAME }}"
                                    data-description="Pay subscription plan"
                                    data-images=""
                                    data-currency="{{__(\App\Models\AppSettings::first()->CURRENCY_CODE)}}"                                    
                                ></script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>

    </div>
</div> 
@endsection

 