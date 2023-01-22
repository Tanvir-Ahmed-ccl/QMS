
@extends('auth.layouts.auth')

@section('content')
  <div class="row w-100 mx-0">
      <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left py-5 px-4 px-sm-5 text-center">
              <div class="brand-logo text-center">
                  {{-- <img src="{{ asset('backend/images/logo.svg') }}"
                  alt="logo"> --}}
                  <a class="nav-link" href="{{ url('') }}">
                        <img src="{{ asset(getSetting('site_logo')) }}" title="" alt="">
                      {{-- <span class="text-primary fw-bolder fs-2">QMS</span> <span> System</span> --}}
                  </a>
              </div>
              <h4>Verify your email address!</h4>

              <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline mt-3" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 mt-3 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </div>
          </div>
      </div>
  </div>
@endsection

