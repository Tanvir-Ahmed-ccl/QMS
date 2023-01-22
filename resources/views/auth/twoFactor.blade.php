@extends('auth.layouts.auth')

@section('title', 'Two Factor Authentication')

@section('content')

<div class="row w-100 mx-0">
    <div class="col-lg-4 mx-auto">
      <div class="auth-form-light text-left py-5 px-4 px-sm-5">
        <div class="brand-logo text-center">
          <a class="nav-link" href="{{ url('/') }}">
          <img src="{{ asset(getSetting('site_logo')) }}" title="" alt="">
              {{-- <span class="text-primary fw-bolder fs-2">QMS</span> <span> System</span> --}}
          </a>
        </div>
        <h4>Two Factor Verification</h4>

        <p class="text-muted">
            You have received an email which contains two factor login code.
        </p>

        @if(session()->has('message'))
            <p class="alert alert-info">
                {{ session()->get('message') }}
            </p>
        @endif
        @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
        @endif
        <form class="pt-3" method="POST" action="{{ route('verify.store') }}">
            @csrf
          <div class="form-group">
            <input name="two_factor_code" type="text"
            class="form-control {{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}"
            required autofocus placeholder="Two Factor Code">
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-white">Verify</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
