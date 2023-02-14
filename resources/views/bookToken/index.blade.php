<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Gokiiw</title>

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
                <div class="card-header text-center bg-primary text-light">
                  @if (!isset($token))
                      <h2>{{$setting->title ?? ''}}</h2>
                  @endif
                </div>

                @if(isset($token))
                <div class="card-body text-center">
                    <h4>{{companyDetails($token->company_id)->title}}</h4>
                    <h1 class="my-3">{{$token->token_no}}</h1>

                    <p class="m-0"><b>Location:</b> {{$token->department->name ?? ''}}</p>
                    <p class="m-0"><b>Service:</b> {{$token->section->name ?? ''}}</p>
                    <p class="m-0"><b>Counter:</b> {{$token->counter->name ?? ''}}</p>
                    <p class="m-0"><b>Officer:</b> {{$token->officer->firstname . ' ' . $token->officer->lastname}}</p>
                    <p class="m-0"><b>Date:</b> {{date("Y-m-d H:i:s", strtotime($token->created_at))}}</p>
                </div>
                @else
                <div class="card-body" style="min-height: 60vh">
                  <div class="row my-3">
                    @foreach ($data as $key => $item)
                      <div class="col-md-3" type="button" data-bs-target="#modal{{$key}}" data-bs-toggle="modal">
                          <div class="card" style="background-color:rgb(79, 79, 211)">
                            <div class="card-body text-center text-light">
                              <b>{{$item['location']['name']}}</b>
                            </div>
                          </div>
                      </div>

                      <div class="modal fade" id="modal{{$key}}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body px-5">
                              <form action="{{route('book.token.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="department_id" value="{{$item['location']['department_id']}}">
                                <input type="hidden" name="counter_id" value="{{$item['location']['counter_id']}}">
                                <input type="hidden" name="user_id" value="{{$item['location']['user_id']}}">
                                <input type="hidden" name="companyId" value="{{ $setting->company_id }}">
                                
                                <div class="form-group mb-3">
                                  <label for=""><b>Select a Service</b></label>
                                  <select name="section_id" class="form-control" required>
                                    <option value="">Select One</option>
                                    @foreach ($item['sections'] as $section)
                                      <option value="{{$section['id']}}">{{$section['name']}}</option>
                                    @endforeach
                                  </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="">Phone Number (<span class="text-danger">* required</span>)</label>
                                    <input name="client_mobile" id="mobile{{$key}}" type="tel" class="form-control mobile" value="+" required>
                                    <button onclick="sendOtp('{{$key}}')" class="btn btn-sm btn-primary">Send OTP</button>
                                </div>

                                <div class="form-group mb-3">
                                  <label for="">OTP</label>
                                    <input name="otp" type="number" id="otp" class="form-control" placeholder="Enter OTP Here" required>
                                    <span  id="otp-alert-msg{{$key}}">Please enter mobile number first</span>
                                </div>

                                <div class="row">
                                  <div class="col-md">
                                    <div class="form-group mb-3">
                                      <label for="">Select Date</label>
                                        <input name="date" type="date" class="form-control" required>
                                    </div>
                                  </div>
                                  <div class="col-md">
                                    <div class="form-group mb-3">
                                      <label for="">Select Time</label>
                                        <input name="time" type="time" class="form-control" required>
                                    </div>
                                  </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="">Your Name (<span class="text-danger">* required</span>)</label>
                                    <input 
                                        type="text"
                                        name="note"
                                        class="form-control"
                                        placeholder="Enter Your Full Name"
                                        onkeydown="return /[a-z]/i/s*.test(event.key)"
                                        required
                                    />
                                    
                                </div>

                                <div class="form-group mb-3">
                                  <label for="">Note (Optional)</label>
                                  <textarea name="note2" id="name" class="form-control" placeholder="Note">{{ old('note') }}</textarea>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" style="margin-right: 10px" type="checkbox" name="agree" value="1" id="defaultCheck1" required>
                                    <label class="form-check-label" for="defaultCheck1">
                                        I agree with the terms and conditions
                                    </label>
                                </div>

                                <button class="btn btn-primary">Submit</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
                @endif
              </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('intelInput/jquery.min.js') }}"></script>
    <script src="{{ asset('intelInput/script.min.js') }}"></script>
    <script>
        function sendOtp(key)
        {
            var phone = $("#mobile"+key).val();

            $.ajax({
                url: "{{ route('guest.send.otp') }}",
                type: 'get',
                data:{
                    phone: phone,
                },
                beforeSend: () => {
                    $("#otp-alert-msg").html("<span class=\"text-success\">Processing to send OTP to your phone ...</span>");
                },
                success: (res) => {
                    // console.log(res);
                    if(res.success == 1)
                    {
                        $("#mobile"+key).attr('readonly','readonly');
                        $("#otp-alert-msg"+key).text("Please check your phone number and enter the OTP here");
                    }
                    else
                    {
                        $("#mobile"+key).val(res.phone);
                        $("#otp-alert-msg"+key).text("something went wrong.");
                    }
                }
            })
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
