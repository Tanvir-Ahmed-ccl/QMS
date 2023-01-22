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
              <form action="{{ route('password.email') }}" method="POST">
                @csrf
                
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

                <div class="d-grid my-3">
                  <button class="btn btn-block w-100 py-2 btn-primary">Send Password reset Link</button>
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
