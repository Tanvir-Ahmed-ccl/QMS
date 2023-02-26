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
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-12">
              <div class="card shadow">
                <div class="card-header text-center bg-primary text-light">
                  <h4>{{companyDetails($data['companyId'])->title}}</h4>
                </div>

                <div class="card-body" style="min-height: 60vh">
                  <div class="row justify-content-center">
                    <div class="col-md-5 py-4">

                      @isset($status)
                          <div class="alert alert-danger">{{$status}}</div>
                      @endisset

                      @if(isset($token))
                      <form action="{{route('book.token.update')}}" method="post" class="card card-body">
                        @csrf
                        <input type="hidden" name="token_id" value="{{$token->id}}">
                        
                        <div class="form-group mb-3">
                          <label for=""><b>Select a {{ trans('app.service') }}</b></label>
                          <select name="section_id" class="form-control" required disabled>
                            <option value="">Select One</option>
                            @foreach ($sections as $section)
                              <option value="{{$section['id']}}" {{($token->section_id == $section['id']) ? 'selected' : ''}} >{{$section['name']}}</option>
                            @endforeach
                          </select>
                        </div>


                        <div class="row">
                          <div class="col-md">
                            <div class="form-group mb-3">
                              <label for="">Select Date</label>
                                <input name="date" type="date" class="form-control" value="{{date('Y-m-d', strtotime($token->created_at))}}" required
                                  
                                />
                            </div>
                          </div>
                          <div class="col-md">
                            <div class="form-group mb-3">
                              <label for="">Select Time</label>
                              @php 
                                $openTime = date("H:i", strtotime(companyDetails($data['companyId'])->opening_time));
                                $closeTime = companyDetails($data['companyId'])->closing_time;
                              @endphp
                              <select name="time" class="form-select">
                                <option value="" selected disabled>Select One</option>
                                @for ($i=1; $i<1000000; $i++)

                                  @if($openTime >= $closeTime)
                                    @break
                                  @endif
                                  
                                  <option value="{{$openTime}}"> {{$openTime}} </option>

                                  @php
                                  $openTime = \Carbon\Carbon::parse($openTime)->addMinutes(5)->format("H:i");
                                  @endphp
                                @endfor
                              </select>
                              {{-- <input name="time" type="time" class="form-control" value="{{date('H:i', strtotime($token->created_at))}}" required> --}}
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
                                value="{{$token->note}}"
                                onkeydown="return /[a-z]/i/s*.test(event.key)"
                                required
                                disabled
                            />
                            
                        </div>

                        <div class="form-group mb-3">
                          <label for="">Note (Optional)</label>
                          <textarea name="note2" id="name" class="form-control" placeholder="Note" disabled>{{$token->note2}}</textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" style="margin-right: 10px" type="checkbox" name="agree" value="1" id="defaultCheck1" checked disabled>
                            <label class="form-check-label" for="defaultCheck1">
                                I agree with the terms and conditions
                            </label>
                        </div>

                        <button class="btn btn-primary">Save</button>
                      </form>
                      @else
                      <form action="{{route('book.token.store')}}" method="post" class="card card-body">
                        @csrf
                        <input type="hidden" name="department_id" value="{{$data['department_id']}}">
                        <input type="hidden" name="counter_id" value="{{$data['counter_id']}}">
                        <input type="hidden" name="user_id" value="{{$data['user_id']}}">
                        <input type="hidden" name="companyId" value="{{ $data['companyId'] }}">
                        <input type="hidden" name="client_mobile" value="{{ $data['client_mobile'] }}">
                        
                        <div class="form-group mb-3">
                          <label for=""><b>Select a {{ trans('app.service') }}</b></label>
                          <select name="section_id" id="section_id" class="form-control" required>
                            <option value="">Select One</option>
                            @foreach ($sections as $section)
                              <option value="{{$section['id']}}" @isset($data['section_id']) {{ ($data['section_id'] == $section->id) ? 'selected' : '' }} @endisset>{{$section['name']}}</option>
                            @endforeach
                          </select>
                        </div>


                        <div class="row">
                          <div class="col-md">
                            <div class="form-group mb-3">
                              <label for="">Select Date</label>
                                <input name="date" type="date" class="form-control" required
                                  @isset($data['date']) value="{{$data['date']}}" @endisset
                                  onchange="getAvailableSchedule(this.value)"
                                >
                            </div>
                          </div>
                          <div class="col-md">
                            <div class="form-group mb-3" id="show-available-time">
                              <label for="">Select Time</label>
                              <input name="time" type="time" class="form-control" required disabled
                                @isset($data['time']) value="{{$data['time']}}" @endisset
                              >
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
                                @isset($data['note']) value="{{$data['note']}}" @endisset
                                required
                            />
                            
                        </div>

                        <div class="form-group mb-3">
                          <label for="">Note (Optional)</label>
                          <textarea name="note2" id="name" class="form-control" placeholder="Note">@isset($data['note2']){{$data['note2']}}@endisset</textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" style="margin-right: 10px" type="checkbox" name="agree" value="1" id="defaultCheck1" required>
                            <label class="form-check-label" for="defaultCheck1">
                                I agree with the terms and conditions
                            </label>
                        </div>

                        <button class="btn btn-primary">Get Token</button>
                      </form>
                      @endif
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

        function getAvailableSchedule(selectedDate)
        {
          let sectionId = $("#section_id").val();

          $.ajax({
            url: "{{route('ajax.getAvailableTime')}}",
            type:"post",
            data: {
              "_token": "{{csrf_token()}}",
              "selectedDate": selectedDate,
              "companyId": "{{$data['companyId']}}",
              "departmentId": "{{$data['department_id']}}",
              "sectionId": sectionId
            },
            beforeSend: () => {

            },
            success: (resp) => {
              $("#show-available-time").html(resp);
            },
            error: (error) => {
              console.log(error);
            }

          })
        }

        function validatingPhoneNumber(phone, key)
        {
            if(phone.length > 6)
            {
              // console.log(phone.length+ "+++++++" + key);
              $("#form-submit-btn-"+key).removeAttr('disabled')
            }
        }

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
