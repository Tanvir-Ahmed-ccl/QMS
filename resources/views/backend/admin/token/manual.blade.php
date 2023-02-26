@extends('layouts.backend')
@section('title', trans('app.manual_token') )
@push('styles')
    <link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">
    <!-- Jquery  -->
    <style>
        .iti{
            display: block !important;
        }
    </style>
@endpush
@section('content')
<div class="panel panel-primary">
 
    <div class="panel-heading">
        <ul class="row list-inline m-0">
            <li class="col-xs-10 xs-view p-0 text-left" id="screen-title">
                <h3>{{ trans('app.manual_token') }}</h3>
            </li>         
            <li class="col-xs-2 p-0 text-right">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#infoModal">
                  <i class="fa fa-info-circle"></i>
                </button>
            </li> 
        </ul>
    </div> 

    <div class="panel-body">

        <div id="output" class="hide alert alert-danger alert-dismissible fade in shadowed mb-1"></div>

        
        <div id="otp-form">
            @if($display->sms_alert)
            <div class="form-group @error('client_mobile') has-error @enderror">
                <label for="client_mobile">{{ trans('app.client_mobile') }} <i class="text-danger">*</i></label> (<span class="text-info">Ex: {{companyDetails(Auth::user()->company_id)->example_phone}}</span>)<br/>
                <input type="tel" value="{{defaultCountryCode(Auth::id())}}" id="mobile" name="client_mobile" class="form-control"
                    onclick="validatingPhoneNumber(this.value)"
                    onkeyup="validatingPhoneNumber(this.value)"
                />
                <span class="text-danger">{{ $errors->first('client_mobile') }}</span>
                <br>
                <button class="btn-sm btn-primary" id="send-otp-btn" onclick="sendOTP(event)" disabled>Send OTP</button>
            </div>  
            
            <div class="form-group @error('otp') has-error @enderror" id="otp-input">
                
            </div>  

            <div id="otp-resp-msg" class="text-danger"></div>
            
            @endif
        </div>

            <div id="after-otp" style="display: none">

            {{ Form::open(['url' => 'admin/token/create', 'class'=>'manualFrm mt-1  col-md-7 col-sm-8']) }}
            <input type="hidden" id="success_mobile" name="client_mobile" > 
                
            {{-- Location --}}
            <div class="form-group @error('department_id') has-error @enderror">
                <label for="department_id">{{ trans('app.department') }} <i class="text-danger">*</i></label><br/>
                <select name="department_id" class="form-control"
                    onchange="loadSection(this.value)"
                >
                    <option value="">Select One</option>
                    @foreach ($departments as $key => $item)
                    <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('department_id') }}</span>
            </div> 

            {{-- service --}}
            <div class="form-group @error('section_id') has-error @enderror" id="ajax-section">
                <label for="section_id">Service <i class="text-danger">*</i></label><br/>
                <select name="section_id" class="form-control">
                    <option value="">Select One</option>
                </select>
            </div> 

            <div class="form-group @error('counter_id') has-error @enderror" id="ajax-counter">
                
                <label for="">{{ trans('app.counter') }}</label>
                <select name="" id="">
                    <option value="">Select One</option>
                </select>

                {{-- <label for="user">{{ trans('app.counter') }} <i class="text-danger">*</i></label><br/>
                {{ Form::select('counter_id', $counters, null, ['placeholder' => 'Select Option', 'class'=>'select2 form-control']) }}<br/>
                <span class="text-danger">{{ $errors->first('counter_id') }}</span> --}}
            </div> 

            <div class="form-group @error('user_id') has-error @enderror" id="ajax-user">

                <label for="">{{ trans('app.officer') }}</label>
                <select name="" id="">
                    <option value="">Select One</option>
                </select>
                {{-- <label for="user">{{ trans('app.officer') }} <i class="text-danger">*</i></label><br/>
                {{ Form::select('user_id', $officers, null, ['placeholder' => 'Select Option', 'class'=>'select2 form-control']) }}<br/>
                <span class="text-danger">{{ $errors->first('user_id') }}</span> --}}
            </div>  

            @if($display->show_note)
            <div class="form-group @error('note') has-error @enderror">
                <label for="note">Name Of Customer <i class="text-danger">*</i></label> 
                <textarea name="note" id="note" class="form-control"  placeholder="{{ trans('app.note') }}">{{ old('note') }}</textarea>
                <span class="text-danger">{{ $errors->first('note') }}</span> 
            </div>
            @endif

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_vip" value="1"> {{ trans('app.is_vip') }}
                </label>
            </div>

            <div class="form-group">
                <button class="button btn btn-info" type="reset"><span>Reset</span></button>
                <button class="button btn btn-success" type="submit"><span>Submit</span></button>
            </div>
            {{ Form::close() }}
            </div>

      
        
    </div> 
</div>  


<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="infoModalLabel"><?= trans('app.note') ?></h4>
      </div>
      <div class="modal-body">
       <p><strong class="label label-warning"> Note 1 </strong> &nbsp;
            <strong>SMS Alert {!! (!empty($display->sms_alert)?("<span class='label label-success'>Active</span>"):("<span class='label label-warning'>Deactive</span>")) !!} </strong>
                        To active or deactive SMS Alert, please change the status of SMS Alert in Setting->Display Settings page
        </p>
        <p><strong class="label label-warning"> Note 2 </strong> &nbsp;
            <strong>Show Note {!! (!empty($display->show_note)?("<span class='label label-success'>Active</span>"):("<span class='label label-warning'>Deactive</span>")) !!} </strong>
            To display note, please change the status of Show Note in Setting->Display Settings page
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
@endsection

@push('scripts')
<script src="{{ asset('intelInput/jquery.min.js') }}"></script>
<script src="{{ asset('intelInput/script.min.js') }}"></script>

<script>
    function validatingPhoneNumber(phone)
    {
        if(phone.length > 6)
        {
            console.log(phone.length);
            $("#send-otp-btn").removeAttr('disabled')
        }
    }


    function sendOTP(e)
    {
        e.preventDefault();
        let phone = $("#mobile").val();
    
        $.ajax({
            url:"{{route('ajax.send.otp')}}",
            type: "GET",
            data:{
                phone:phone
            },
            beforeSend: () => {
                $("#send-otp-btn").html('Sending...');
            },
            success: function(res){
                $("#mobile").attr('readonly','readonly');
                $("#send-otp-btn").html('Resend OTP');
                $("#otp-input").html('<label for="">Please check the phone and enter the OTP</label><input type="number" name="otp" id="otp" class="form-control" /> <button id="check-otp" onclick="checkOTP(event)">Submit</button>');
            }
        })
    }


    function checkOTP(e)
    {
        e.preventDefault();
        let phone = $("#mobile").val();
        let otp = $("#otp").val();

        $.ajax({
            url:"{{route('ajax.send.otp')}}",
            type: "GET",
            data:{
                phone:phone,
                otp:otp
            },
            beforeSend: () => {
                $("#check-otp").html('Checking...');
            },
            success: function(res){
                if(res.success == 1)
                {
                    $("#otp-form").hide();
                    $("#after-otp").css("display", "block");
                    $("#success_mobile").val(phone)
                }
                else
                {
                    $("#check-otp").html('Submit');
                    $("#otp-resp-msg").html(`<b>${res.message}</b>`);
                }
            }
        })
    }

    function loadCounter(key)
    {
        $.ajax({
            url:"{{route('ajax.load.counter')}}",
            type: "GET",
            data:{
                locationId:key
            },
            success: function(res){
                $("#ajax-counter").html(res);
            }
        })
    }


    function loadSection(key)
    {
        $.ajax({
            url:"{{route('ajax.load.section')}}",
            type: "GET",
            data:{
                key:key
            },
            success: function(res){
                $("#ajax-section").html(res);
            }
        })
    }


    function loadUser(key)
    { 
        // alert(key);
        $.ajax({
            url:"{{route('ajax.load.user')}}",
            type: "GET",
            data:{
                counterId:key
            },
            success: function(res){
                $("#ajax-user").html(res);
            }
        })
    }
</script>

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
            preferredCountries: [],
            preventInvalidNumbers: true,
        });
    });
</script>
<script type="text/javascript">
(function() {
    $('input[name=client_mobile]').on('keyup change', function(e){
        var valid = true;
        var errorMessage;
        var mobile = $(this).val();

        if (mobile == '')
        {
            errorMessage = "The Mobile No. field is required!";
            valid = false;
        } 
        else if(!$.isNumeric(mobile)) 
        {
            errorMessage = "The Mobile No. is incorrect!";
            valid = false;
        }
        else if (mobile.length >= 15 || mobile.length < 7)
        {
            errorMessage = "The Mobile No. must be between 7-15 digits";
            valid = false;
        }

        if(!valid && errorMessage.length > 0)
        {
            $(this).next().next().next().html(errorMessage);
            $('.modal button[type=submit]').addClass('hidden');
        } 
        else
        {
            $(this).next().next().next().html(" ");
            $('.modal button[type=submit]').removeClass('hidden');
        } 
    }); 
      
    var frm = $(".manualFrm");
    frm.on('submit', function(e){
      e.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        dataType: 'json', 
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        contentType: false,  
        cache: false,  
        processData: false,
        data:  new FormData($(this)[0]),
        success: function(data)
        {
            if (data.status)
            { 
                $(".manualFrm").trigger('reset');
                $("#output").html('').addClass('hide');
                $("#mobile").removeAttr('readonly');
				$("#after-otp").css("display", "none");				
				$("#mobile").val("+");
				$("#otp-input").html("");
				$("#otp-form").show();
                alert(data.message);

                var content = "<style type=\"text/css\">@media print {"+
                    "html, body {display:block;margin:0!important; padding:0 !important;overflow:hidden;display:table;}"+
                    ".receipt-token {width:100vw;height:100vw;text-align:center}"+
                    ".receipt-token h4{margin:0;padding:0;font-size:7vw;line-height:7vw;text-align:center}"+
                    ".receipt-token h1{margin:0;padding:0;font-size:15vw;line-height:20vw;text-align:center}"+
                    ".receipt-token ul{margin:0;padding:0;font-size:7vw;line-height:8vw;text-align:center;list-style:none;}"+
                    "}</style>";
                    
                content += "<div class=\"receipt-token\">";
                content += "<h4>{{ \Session::get('app.title') }}</h4>";
                content += "<h1>"+data.token.token_no+"</h1>";
                content +="<ul class=\"list-unstyled\">";
                content += "<li><strong>{{ trans('app.department') }} </strong>"+data.token.department+"</li>";
                content += "<li><strong>{{ trans('app.counter') }} </strong>"+data.token.counter+"</li>";
                content += "<li><strong>{{ trans('app.officer') }} </strong>"+data.token.firstname+' '+data.token.lastname+"</li>";
                if (data.token.note)
                {
                    content += "<li><strong>{{ trans('app.note') }} </strong>"+data.token.note+"</li>";
                }
                content += "<li><strong>{{ trans('app.date') }} </strong>"+data.token.created_at+"</li>";
                content += "</ul>";  
                content += "</div>";    

                // print 
                // printThis(content);

            } 
            else 
            {  
                alert(data.exception)
                $("#output").html(data.exception).removeClass('hide');
            }
        },
        error: function(xhr)
        {
            alert('failed...');
        }
      });
    });
})();
</script>
@endpush
 
 