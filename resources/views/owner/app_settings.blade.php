@extends('owner.layouts.app')


@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Settings</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('owner/dashboard') }}">Home</a></li>
                            <li class="active">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <!-- Row -->
        <div class="row mt-3 justify-content-center align-items-center">
           <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('owner.app.settings.update') }}" method="POST" enctype="multipart/form-data" id="updateForm">
                            @csrf

                            
                            @if ($what == 'web')
                                <input type="hidden" name="what" value="{{ $what }}">
                                <div class="mb-3">
                                    <label for="">App Logo</label><br>
                                    <img src="{{ asset(\App\Models\AppSettings::first()->APP_LOGO ?? "d/your-logo.png") }}" alt="App Logo" class="bg-dark img-fluid" width="200">
                                    <input type="file" name="APP_LOGO" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="">App Name</label>
                                    <input type="text" name="APP_NAME" id="appName" class="form-control" value="{{ \App\Models\AppSettings::first()->APP_NAME }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="">Copyright Text</label>
                                    <input type="text" name="COPYRIGHT_TEXT" class="form-control" value="{{ \App\Models\AppSettings::first()->COPYRIGHT_TEXT }}">
                                </div>

                                <h5 class="mt-5 mb-0">
                                    <b>Currency</b>
                                </h5>
                                <hr class="mt-0">

                                <div class="mb-3">
                                    <label for="">Currency Sign</label>
                                    <input type="text" name="CURRENCY_SIGN" class="form-control" value="{{ __(\App\Models\AppSettings::first()->CURRENCY_SIGN) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="">Currency Code</label>
                                    <input type="text" name="CURRENCY_CODE" class="form-control" value="{{ __(\App\Models\AppSettings::first()->CURRENCY_CODE) }}">
                                </div>

                            @endif

                            @if ($what == 'stripe')
                                <input type="hidden" name="what" value="{{ $what }}">
                                <h5 class="mt-5 mb-0">
                                    <b>Stripe</b>
                                </h5>
                                <hr class="mt-0">

                                <div class="mb-3">
                                    <label for="">Stripe App Key</label>
                                    <input type="text" name="STRIPE_KEY" class="form-control" value="{{ __(\App\Models\AppSettings::first()->STRIPE_KEY) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="">Stripe Secret Key</label>
                                    <input type="text" name="STRIPE_SECRET" class="form-control" value="{{ __(\App\Models\AppSettings::first()->STRIPE_SECRET) }}">
                                </div>
                            @endif


                            @if ($what == 'twilio')
                            <input type="hidden" name="what" value="{{ $what }}">
                            <h5 class="mt-5 mb-0">
                                <b>Twilio SMS</b>
                            </h5>
                            <hr class="mt-0">

                            <div class="mb-3">
                                <label for="">Twilio SID</label>
                                <input type="text" name="tw_sid" class="form-control" value="{{ __(\App\Models\AppSettings::first()->TW_SID) }}">
                            </div>

                            <div class="mb-3">
                                <label for="">Twilio TOKEN</label>
                                <input type="text" name="tw_token" class="form-control" value="{{ __(\App\Models\AppSettings::first()->TW_TOKEN) }}">
                            </div>

                            <div class="mb-3">
                                <label for="">Twilio FROM</label>
                                <input type="text" name="tw_from" class="form-control" value="{{ __(\App\Models\AppSettings::first()->TW_FROM) }}">
                            </div>
                            @endif

                            @if ($what == 'smtp')
                            <h5 class="mt-5 mb-0">
                                <b>SMTP Details</b>
                            </h5>
                            <hr class="mt-0">

                            <div class="mb-3">
                                <label for="">Mail Host</label>
                                <input type="text" name="MAIL_HOST" class="form-control" value="{{ __(\App\Models\AppSettings::first()->MAIL_HOST) }}">
                            </div>
                            <div class="mb-3">
                                <label for="">Mail Port</label>
                                <input type="text" name="MAIL_PORT" class="form-control" value="{{ __(\App\Models\AppSettings::first()->MAIL_PORT) }}">
                            </div>
                            <div class="mb-3">
                                <label for="">Mail Username</label>
                                <input type="text" name="MAIL_USERNAME" class="form-control" value="{{ __(\App\Models\AppSettings::first()->MAIL_USERNAME) }}">
                            </div>
                            <div class="mb-3">
                                <label for="">Mail Password</label>
                                <input type="text" name="MAIL_PASSWORD" class="form-control" value="{{ __(\App\Models\AppSettings::first()->MAIL_PASSWORD) }}">
                            </div>
                            <div class="mb-3">
                                <label for="">Mail Encryption</label>
                                <input type="text" name="MAIL_ENCRYPTION" class="form-control" value="{{ __(\App\Models\AppSettings::first()->MAIL_ENCRYPTION) }}">
                            </div>
                            <div class="mb-3">
                                <label for="">Mail From Address</label>
                                <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" value="{{ __(\App\Models\AppSettings::first()->MAIL_FROM_ADDRESS) }}">
                            </div>
                            @endif

                            
                            <div class="mt-4">
                                <button class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
           </div>            
        </div>
        <!-- //. Row -->

    </div><!-- .animated -->
</div><!-- .content -->
@endsection
