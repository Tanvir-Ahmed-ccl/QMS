<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{env("APP_NAME")}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  
  
    <style>
      .form-control{
        border: none;
        background: none;
        border-radius: 0;
        color: #fff;
      }
      .form-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */
          color: #ffffff;
        }

      .form-control:focus{
        border-bottom: 1px solid white !important;
        background: none;
        border-radius: 0;
        color: #ffffff;
      }
    </style>
  </head>
  <body>

    <div class="row min-vh-100 p-0 m-0 align-items-center justify-content-center" style="background-color: #3498DB">
        
      <div class="col-lg-8">
          <a href="{{ url('/') }}">
            <h1 style="position: fixed; top:30px; left: 90px; color:#fff"><strong>{{ env('APP_NAME') }}</strong></h1>
          </a>          

          <div class="container" style="margin-top: 30px">
            <div class="row p-0 m-0 justify-content-center text-white">              

              <div class="col-md-8 p-4">

                <h1>Log In</h1>
                {{-- <h5>Don't have an account? <a href="{{ route('signup') }}" class="text-dark">Sign up here</a></h5> --}}

                @if (isset($msg) && isset($email))
                <div class="row">
                  <span class="alert alert-danger">
                    <strong>{{ $msg }}</strong>
                  </span>
                  <form action="{{ route('resendOtp') }}" method="post" id="resendOtpForm">
                    @csrf
                    <input type="hidden" name="email" value="{{$email}}">
                    <input type="hidden" name="password" value="{{$password}}">
                  </form>
                </div>
                <form action="{{ route('checkOtp') }}" method="POST" class="mt-5" id="checkOtpForm">
                  @csrf
                  <input type="hidden" name="email" value="{{$email}}">
                  <input type="hidden" name="password" value="{{$password}}">
                  
                  <div class="my-3">
                    <label for=""><strong>OTP</strong></label>
                    <input type="number" name="otp" required
                    autocomplete="off"
                    placeholder="XXXXXX" class="form-control border-bottom border-dark">                    
                  </div>

                  {{-- @if ($errors->any())
                    <div class="row">
                      <span class="alert alert-danger">
                        <strong>{{ $errors->first() }}</strong>
                      </span>
                    </div>
                  @endif --}}
                  
                </form>
                <div class="text-end">
                  <button class="btn btn-light text-primary fw-bolder me-2" 
                    onclick="document.getElementById('resendOtpForm').submit()">Resend OTP</button>
                  <button class="btn btn-light text-primary fw-bolder"
                    onclick="document.getElementById('checkOtpForm').submit()">LOG IN</button>
                </div>

                @else
                <form action="{{ route('sendOtp') }}" method="POST" class="mt-5">
                  @csrf
                  <div class="my-3">
                    <label for=""><strong>Email</strong></label>
                    <input type="text" name="email" required
                    value="{{ old('email') }}"
                    autocomplete="off"
                    placeholder="john@example.com" class="form-control border-bottom border-dark">
                    

                    @error('email')
                      <span class="text-danger">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    
                  </div>

                  <div class="my-5">
                    <label for=""><strong>Password</strong></label>
                    <input type="password" name="password" required
                    value="{{ old('password') }}"
                    placeholder="Enter your Password" class="form-control border-bottom border-dark">

                    @error('password')
                      <span class="text-danger">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  @if (session()->has('exception'))
                    <div class="row">
                      <span class="alert alert-danger">
                        <strong>{{ session('exception') }}</strong>
                      </span>
                    </div>
                  @endif
                  
                  <div class="row">
                    <div class="col">
                      <a href="{{ route('password.request') }}" class="btn-link text-decoration-none text-white">Forgot your password?</a>
                    </div>
                    <div class="col text-end">
                      <button class="btn btn-light text-primary fw-bolder">LOG IN </button>
                    </div>
                  </div>
                </form>
                @endif
              </div>
            </div>
          </div>

        </div>
        <!--  .col-lg-7  -->

        <div class="col-lg-4 bg-white d-lg-block d-none">
            <div class="row min-vh-100 align-items-center p-3">
                <div class="col">
                  <h4>Welcome to {{env('APP_NAME')}} system</h4>
                 
                  <img src="{{ asset('d/qms-icon.jpg') }}" alt="" class="rounded-circle" width="200">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
