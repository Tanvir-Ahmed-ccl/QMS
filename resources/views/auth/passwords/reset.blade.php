<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Gokiiw</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
 
  </head>
  <body style="background-color: #EBF0F0">   


    <div class="container">
      <div class="row min-vh-100 align-items-center justify-content-center">
        
        <div class="col-lg-6">
          <div class="text-center mb-5">
            <a href="{{ url('/') }}" class="text-decoration-none">
              <h1 class="text-primary">{{ env('APP_NAME') }}</h1>
            </a>
          </div>
          <div class="card border-0 p-4">
            <div class="card-body">
              @if (\Session::has('status'))
                  <div class="fw-bolder alert alert-success">
                    {!! \Session::get('status') !!}
                  </div>
              @else
              <form action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail"
                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    <label for="floatingEmail">Email address</label>

                    @error('email')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword"
                        required autocomplete="new-password">
                    <label for="floatingPassword">Password</label>

                    @error('password')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password_confirmation" class="form-control" id="floatingPasswordConfirm"
                        required autocomplete="new-password">
                    <label for="floatingPasswordConfirm">Confirm Password</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn w-100 btn-primary">
                        {{ __('Reset Password') }}
                    </button>
                </div>
              </form>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
