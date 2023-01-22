<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - {{ env('APP_NAME') }}</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('images/logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.svg') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap" style="min-height: 100vh">
        <div class="container">
            <div class="login-content">
                
                {{-- <img src="" alt="Logo" class="img-fluid m-auto d-block" width="500"> --}}
                <div class="text-center">
                    <h1 class="text-light mb-3"><b>Go kiiw</b></h1>
                </div>

                <div class="login-form">
                    @if (isset($email) && isset($password))
                    <div class="alert alert-success">
                        {{$message}}
                    </div>

                    <form action="{{ route('owner.otp.login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="password" value="{{$password}}">

                        <div class="form-group">
                            <label>Enter Otp</label>
                            <input type="number" name="otp" class="form-control" placeholder="OTP" value="{{ old('otp') }}">
                            @error('otp')
                                <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success">Log in</button>
                        
                    </form>
                    @else
                    <form action="{{ route('owner.login') }}" method="POST">
                        @csrf


                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            @error('password')
                                <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Log in</button>
                        
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>
