@extends('layouts.backend')
@section('title', "User Type")
 

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <ul class="row list-inline m-0">
            <li class="col-xs-10 p-0 text-left">
                <h3>Addons</h3>
            </li>
        </ul>
    </div>

    <div class="panel-body table-responsive">
        <div class="row">
            @foreach ($rows as $item)
            <div class="col-sm-4 mb-4">
                <div class="card" style="border: 1.5px solid rgb(78, 131, 230); text-align:center; padding: 10px">
                    <div class="card-body">
                        <div class="mb-3">
                            <h3 style="font-weight: bolder">{{ $item->title }}</h3>
                            <h2 style="font-weight: bolder">{{\App\Models\AppSettings::first()->CURRENCY_SIGN}} {{ $item->price }} <small>/mo</small></h2>
                        </div>
                        <div class="my-4">
                            {!! $item->description !!}
                        </div>

                        
                        @if(\App\AddonUsesHistory::where('user_id', companyOwner(Auth::id())->id)->where('addon_id', $item->id)->exists())
                            <?php
                                $package = \App\AddonUsesHistory::where('user_id', companyOwner(Auth::id())->id)->where('addon_id', $item->id)->first();
                            ?>
                            Expired At: {{ date("Y-m-d H:i:s", strtotime($package->purchase_out)) }}
                        
                        <br>    <button class="btn btn-primary" style="margin: 10px 0">Active</button>
                        
                        @else

                        <div style="margin: 10px 0">
                            <form action="{{ route('addon.purchase') }}" method="POST">
                                @csrf
                                <input type="hidden" name="addon_id" value="{{ $item->id }}">
                                <input type="hidden" name="amount" value="{{ $item->price }}">
                                <script 
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key = "{{ App\Models\AppSettings::first()->STRIPE_KEY }}"
                                    data-amount="{{__($item->price * 100)}}"
                                    data-name="{{ \App\Models\AppSettings::first()->APP_NAME }}"
                                    data-description="Pay subscription plan"
                                    data-images=""
                                    data-currency="{{__(\App\Models\AppSettings::first()->CURRENCY_CODE)}}"                                    
                                ></script>
                            </form>
                        </div>
                        
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</div> 
@endsection