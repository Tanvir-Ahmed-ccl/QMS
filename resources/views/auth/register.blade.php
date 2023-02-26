<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup | Gokiiw</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">

    <style>
      .iti{
        display: block !important;
      }
    </style>
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
                <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row">

                  <div class="col-lg">
                    <div class="form-floating mb-3">
                      <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" required>
                      <label for="first_name">First Name</label>

                      @error('first_name')
                      <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg">
                    <div class="form-floating mb-3">
                      <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" required>
                      <label for="last_name">Last Name</label>

                      @error('last_name')
                      <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                </div>
                

                <div class="form-floating mb-3">
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" autocomplete="off" 
                  value="{{ old('email') }}" required>
                  <label for="floatingInput">Email address</label>

                  @error('email')
                  <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="mobile">Mobile Number</label><br>
                  <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="+XXXXXXXXXXX" autocomplete="off" 
                    value="{{ old('mobile') }}" required
                  >
                  

                  @error('mobile')
                  <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-floating">
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" 
                  value="{{ old('password') }}" required>
                  <label for="floatingPassword">Password</label>

                  @error('password')
                  <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>


                <div class="row my-3">
                  <div class="col-12 text-center my-3">
                    <small>By signing up, you agree to our <a href="{{route('terms')}}" target="_blank">Terms of Service</a></small>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-block w-100 py-2 btn-primary">Start free trial</button>
                  </div>
                </div>
              </form>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('intelInput/jquery.min.js') }}"></script>
    <script src="{{ asset('intelInput/script.min.js') }}"></script>
    <script>
        $(function() {
            $("#mobile").intlTelInput({
                allowExtensions: true,
                autoFormat: false,
                autoHideDialCode: false,
                autoPlaceholder: false,
                // defaultCountry: "gh",
                // ipinfoToken: "yolo",
                nationalMode: false,
                numberType: "MOBILE",
                //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                preferredCountries: ['gh', 'us'],
                preventInvalidNumbers: true,
                // utilsScript: "{{asset('js/utils.js')}}"
            });
        });
    </script>
  </body>
</html>
