<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <title>{{env("APP_NAME")}}</title>

    <link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">
    <style>
        .iti{
            display: block !important;
        }
    </style>
  </head>
  <body>
    <div class="container py-5 my-3">
        <div class="row align-items-center">
            <div class="col-12">
              <div class="card shadow">
                <div class="card-header bg-primary text-light">
                  <div class="row text-center">
                    <div class="col-2"><a href="{{route('book.token.index', companyToken($data['companyId']))}}" class="text-light"> <i class="bi bi-arrow-left"></i> Back</a></div>
                    <div class="col"><h4>{{companyDetails($data['companyId'])->title}}</h4></div>
                  </div>
                </div>

                <div class="card-body" style="min-height: 60vh">
                  <div class="row mt-5 justify-content-center align-items-center">
                    <div class="col-md-5">
                      <div class="card">
                        <div class="card-body px-4">

                         @isset($status)
                             <div class="alert alert-danger">{{$status}}</div>
                         @endisset
                          
                          @if(isset($client_mobile))
                          <form action="{{route('book.token.auth.otp.check')}}" method="post">
                            @csrf
                            <input type="hidden" name="department_id" value="{{$data['department_id']}}">
                            <input type="hidden" name="counter_id" value="{{$data['counter_id']}}">
                            <input type="hidden" name="user_id" value="{{$data['user_id']}}">
                            <input type="hidden" name="companyId" value="{{ $data['companyId'] }}">
                            
                            <div class="form-group mb-3" id="otp-phone">
                                <label for="">Enter Your Phone Number (<span class="text-danger">* required</span>)</label>
                                
                                <input 
                                  name="client_mobile" 
                                  id="mobile" 
                                  type="tel" 
                                  class="form-control mobile"
                                  value="{{$client_mobile}}"
                                  readonly
                                />
                            </div>


                            <div class="form-group mb-3" id="otp-phone">
                                <label for="">Enter OTP (<span class="text-danger">* required</span>)</label>
                                
                                <input 
                                  type="number"
                                  name="otp"
                                  class="form-control"
                                  required
                                  value="{{ (isset($data['otp'])) ? $data['otp'] : '' }}"
                                />
                            </div>
                          
                            <button class="w-100 btn btn-primary" id="form-submit-btn" />Submit</button>

                            <center>
                              <a href="javascript::" onclick="document.getElementById('resendOtpForm').submit()" class="mt-3 mx-auto">Resend OTP</a>
                            </center>
                          </form>

                          <form action="{{ route('book.token.auth.otp') }}" method="post" id="resendOtpForm">
                            @csrf
                            <input type="hidden" name="department_id" value="{{$data['department_id']}}">
                            <input type="hidden" name="counter_id" value="{{$data['counter_id']}}">
                            <input type="hidden" name="user_id" value="{{$data['user_id']}}">
                            <input type="hidden" name="companyId" value="{{ $data['companyId'] }}">

                            <input type="hidden" name="client_mobile" value="{{$client_mobile}}">
                          </form>

                          @else
                          
                          <form action="{{route('book.token.auth.otp')}}" method="post">
                            @csrf
                            <input type="hidden" name="department_id" value="{{$data['department_id']}}">
                            <input type="hidden" name="counter_id" value="{{$data['counter_id']}}">
                            <input type="hidden" name="user_id" value="{{$data['user_id']}}">
                            <input type="hidden" name="companyId" value="{{ $data['companyId'] }}">
                            
                            

                            <div class="form-group mb-3" id="otp-phone">
                                <label for="">Enter Your Phone Number (<span class="text-danger">* required</span>)</label> <br> (<small class="text-info">Ex: {{companyDetails($data['companyId'])->example_phone}}</small>)
                                
                                <input 
                                  name="client_mobile" 
                                  id="mobile" 
                                  type="tel" 
                                  class="form-control mobile"
                                  value="{{defaultCountryCode($data['companyId'])}}" 
                                  required
                                  onclick="validatingPhoneNumber(this.value)"
                                  onkeyup="validatingPhoneNumber(this.value)"
                                />
                            </div>
                          

                            <button 
                              class="w-100 btn btn-primary" 
                              id="form-submit-btn" 
                              disabled 
                            />Send OTP</button>
                          </form>

                          @endif

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('intelInput/jquery.min.js') }}"></script>
    <script src="{{ asset('intelInput/script.min.js') }}"></script>
    <script>

        function validatingPhoneNumber(phone)
        {
            if(phone.length > 6)
            {
              // console.log(phone.length+ "+++++++" + key);
              $("#form-submit-btn").removeAttr('disabled')
            }
        }

        
        $(".mobile").intlTelInput({
            allowExtensions: true,
            autoFormat: false,
            autoHideDialCode: false,
            autoPlaceholder: false,
            // defaultCountry: "gh",
            defaultCountry: null,
            // ipinfoToken: "yolo",
            nationalMode: false,
            numberType: "MOBILE",
            // preferredCountries: ['gh', 'us'],
            preventInvalidNumbers: true,
        });
    </script>

  </body>
</html>
