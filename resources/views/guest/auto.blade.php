@extends('guest.layout')
@section('title', trans('app.auto_token'))

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
@endpush

@section('content')
<style>
    .btn{
        display: block !important;
    }
</style>

<div class="panel panel-primary" id="toggleScreenArea">
    <div class="panel-body">
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    @forelse (\App\Ads::selfData($company->company_id) as $item)
                        <div class="item">
                            <a href="{{$item->link}}" target="_blank">
                                <img src="{{asset($item->images)}}" alt="banner" class="img-fluid" style="height: 100px; width: 100%; margin: auto auto">
                            </a>
                        </div>
                    @empty
                        
                    @endforelse
                </div>
            </div>            
        </div>


        <div class="row text-center" id="screen-content">

            <!-- With Mobile No -->
            @foreach ($departmentList as $department)
            <div class="col-sm-3 bg-primary capitalize text-center p-1 m-1">
                <button 
                    onclick="loadRelatedSection('{{ $department->department_id }}', '{{$company->company_id}}')"
                    type="button" 
                    class="btn btn-primary" style="width: 100%"
                    {{-- style="min-width: 15vw;white-space: pre-wrap;box-shadow:0px 0px 0px 2px#<?= substr(dechex(crc32($department->name)), 0, 6); ?>"  --}}
                    data-toggle="modal" 
                    data-target="#tokenModal"
                    data-department-id="{{ $department->department_id }}"
                    data-counter-id="{{ $department->counter_id }}"
                    data-user-id="{{ $department->user_id }}"
                    >
                        <h5>{{ $department->name }}</h5>
                        <h6>{{ \App\Models\Token::where([
                                        'company_id'    => $company->company_id,
                                        'department_id' => $department->department_id,
                                        // 'counter_id'    => $department->counter_id, 
                                        // 'user_id'       => $department->user_id,
                                        'status'        =>  0
                                    ])->whereDate('created_at', date("Y-m-d"))->count() }} People in Queue</h6>
                        {{-- <h6>{{ $department->officer }}</h6> --}}
                </button>  
            </div>
            @endforeach  
            <!--Ends of With Mobile No -->   
            
            
        </div>  

        @if (!is_null($setting->announcement))
        <div class="row">
            <div class="col-12" style="background-color: #000; color: red">
                <h2 style="font-weight: bolder"><marquee direction="rtl">{{ $setting->announcement }}</marquee></h2>
            </div>
        </div>
        @endif
    </div> 
</div>  


<div class="modal fade" tabindex="-1" id="tokenModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ trans('app.user_information') }}</h4>
      </div>
      <div class="modal-body">
        
        <div id="otp-form">
            <div class="form-group mb-3">
                Mobile Number <span class="text-danger">*</span>(<span class="text-info">Ex: {{companyDetails($company->company_id)->example_phone}}</span>)
                <input name="client_mobile" type="tel" id="mobile" class="form-control" value="{{$setting->country_code}}" placeholder="{{ trans('app.client_mobile') }}" required>
                <button onclick="sendOtp()" id="sendOtpBtn" class="btn btn-sm btn-primary">Send OTP</button>                
            </div>

            <p>
                <input name="otp" type="number" id="otp" class="form-control" placeholder="Enter OTP Here" required>
                <span  id="otp-alert-msg">Please enter mobile number first</span>
            </p>

            <button class="btn btn-success" id="check-otp" onclick="checkOTP(event)">Submit</button>

            <div id="otp-resp-msg" class="text-danger"></div>
        </div>
        
      {{ Form::open(['url' => 'guest/token', 'class' => 'AutoFrm']) }} 


        <div id="after-otp" style="display: none">
        {{-- <div id="after-otp"> --}}

            <input name="client_mobile" type="hidden" id="success_mobile" class="form-control">
            
            {{-- <div class="form-group mb-3">
                Mobile Number <span class="text-danger">*</span>(<span class="text-info">Ex: {{companyDetails($company->company_id)->example_phone}}</span>)
                <input name="client_mobile" type="tel" id="mobile" class="form-control" value="{{$setting->country_code}}" placeholder="{{ trans('app.client_mobile') }}" required>
            </div> --}}
            
            <p >
                <label for="">Services</label>
                <select name="section_id[]" id="ajax-section-load" class="form-control" multiple>
                    <option value="">Select Option</option>
                </select>
                <span class="text-danger">This field is required</span>
            </p>

            <p>
                <input 
                    type="text"
                    name="note"
                    class="form-control"
                    placeholder="Your Full Name"
                    onkeydown="return /[a-z, ]/i.test(event.key)"
                    required
                />
                <span class="text-danger">The Name field is required!</span>
            </p>
            <p>
                <textarea name="note2" id="name" class="form-control" placeholder="Note">{{ old('note') }}</textarea>
                <span class="text-muted">The Note field is optional!</span>
            </p>


            <div class="form-check">
                <input class="form-check-input" style="margin-right: 10px" type="checkbox" name="agree" value="1" id="defaultCheck1" required>
                <label class="form-check-label" for="defaultCheck1">
                    I agree with the terms and conditions
                </label>
            </div>


            <input type="hidden" name="department_id">
            <input type="hidden" name="counter_id">
            <input type="hidden" name="user_id">
            <input type="hidden" name="companyId" value="{{ $company->company_id }}">
        
            <div class="modal-footer">
                <button type="submit" class="btn btn-success hidden">{{ trans('app.submit') }}</button>
            </div>
        </div>
      
      {{ Form::close() }}

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
    </script>
@endpush

@push("scripts")
<script>

    function sendOtp()
    {
        var phone = $("#mobile").val();

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
                    $("#sendOtpBtn").text("Resend OTP")
                    $("#mobile").attr('readonly','readonly');
                    $("#otp-alert-msg").text("Please check your phone number and enter the OTP here");
                }
                else
                {
                    $("#mobile").val(res.phone);
                    $("#otp-alert-msg").text("something went wrong.");
                }
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
                    if(res.data.phoneExists == 1)
                    {
                        location.replace("{{url('')}}/guest/token/edit/"+res.data.tokenId);
                    }
                    else
                    {
                        $("#otp-form").hide();
                        $("#after-otp").css("display", "block");
                        $("#success_mobile").val(phone);
                    }
                }
                else
                {
                    $("#check-otp").html('Submit');
                    $("#otp-resp-msg").html(res.message);
                }
            }
        })
    }


    function loadRelatedSection(deptId, companyId)
    {
        $.ajax({
            url: "{{ route('get.section') }}",
            type: 'GET',
            data:{
                departmentId: deptId,
                companyId: companyId
            },
            success: (res) => {
                // console.log(res);
                if(res.items > 0)
                {
                    $("#ajax-section-load").append(res.html);
                }
                else
                {
                    $("#ajax-section-load").html('');
                }
            }
        })
    }

</script>

<script type="text/javascript">
(function($) {


    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('input[name=department_id]').val(button.data('department-id'));
        $('input[name=counter_id]').val(button.data('counter-id'));
        $('input[name=user_id]').val(button.data('user-id'));

        // $("input[name=client_mobile]").val("+");
        $("textarea[name=note]").val("");
        $('.modal button[type=submit]').addClass('hidden');
    });

    $('.modal').on('hide.bs.modal', function () {
        $('.modal-backdrop').remove();
    });

    // $("input[name=client_mobile], textarea[name=note]").on('keyup change', function(e){
    //     var valid = false;
    //     var mobileErrorMessage = "";
    //     var noteErrorMessage = "";
    //     var mobile = $('input[name=client_mobile]').val();
    //     var note   = $('textarea[name=note]').val();

    //     if ($('input[name=client_mobile]').length)
    //     {
    //         if (mobile == '')
    //         {
    //             mobileErrorMessage = "The Mobile No. field is required!";
    //             valid = false;
    //         } 
    //         else if(!$.isNumeric(mobile)) 
    //         {
    //             mobileErrorMessage = "The Mobile No. is incorrect!";
    //             valid = false;
    //         }
    //         else if (mobile.length >= 15 || mobile.length < 7)
    //         {
    //             mobileErrorMessage = "The Mobile No. must be between 7-15 digits";
    //             valid = false;
    //         } 
    //         else
    //         { 
    //             mobileErrorMessage = "";
    //             valid = true;
    //         }   
    //     }   

    //     if ($('textarea[name=note]').length)
    //     {
    //         if (note == '')
    //         {
    //             noteErrorMessage = "The Note field is required!";
    //             valid = false;
    //         }
    //         else if (note.length >= 255 || note.length < 0)
    //         {
    //             noteErrorMessage = "The Note must be between 1-255 characters";
    //             valid = false;
    //         }
    //         else
    //         {
    //             noteErrorMessage = "";
    //             valid = true;
    //         }
    //     }


    //     if(!valid && mobileErrorMessage.length > 0)
    //     {
    //         $('.modal button[type=submit]').addClass('hidden');
    //     } 
    //     else if(!valid && noteErrorMessage.length > 0)
    //     {
    //         $('.modal button[type=submit]').addClass('hidden');
    //     } 
    //     else
    //     {
    //         $(this).next().html(" ");
    //         $('.modal button[type=submit]').removeClass('hidden');
    //     }
    //     $('textarea[name=note]').next().html(noteErrorMessage);
    //     $('input[name=client_mobile]').next().html(mobileErrorMessage);  

    // });

    var frm = $(".AutoFrm");
    frm.on('submit', function(e){
        e.preventDefault(); 
        $(".modal").modal('hide');
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "{{url('guest/phone/check')}}",
            type: 'GET',
            data:{
                client_mobile: $("input[name=client_mobile]").val(),
            },
            success: (res) => {
                console.log(res);
                if(res.phoneExists == 1)
                {
                    if(confirm("Are you sure! You want to join again?"))
                    {
                        location.replace("{{url('')}}/guest/token/edit/"+res.tokenId);
                    }
                }
                else
                {
                    ajax_request(formData);
                }
            },
            error: (err) => {
                console.log(err);
            }
        });
    });


    function ajax_request(formData)
    {
        $.ajax({
            url: '{{ url("guest/token") }}',
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            contentType: false,
            cache: false,
            processData: false,
            data:  formData,
            success: function(data)
            {
                console.log(data);
                if (data.status)
                {
                    var content = "<style type=\"text/css\">@media print {"+
                        "html, body {display:block;margin:0!important; padding:0 !important;overflow:hidden;display:table;}"+
                        ".receipt-token {width:100vw;height:100vw;text-align:center}"+
                        ".receipt-token h4{margin:0;padding:0;font-size:7vw;line-height:7vw;text-align:center}"+
                        ".receipt-token h1{margin:0;padding:0;font-size:15vw;line-height:20vw;text-align:center}"+
                        ".receipt-token ul{margin:0;padding:0;font-size:7vw;line-height:8vw;text-align:center;list-style:none;}"+
                        "}</style>";

                    content += "<div class=\"receipt-token\">";
                    content += "<h4>"+data.title+"</h4>";
                    content += "<h1>"+data.token.token_no+"</h1>";

                    if(data.services != null)
                    {
                        content += `<div style="display:block;margin-bottom:10px"><center>`;
                        
                        for(key in data.services)
                        {
                            if(key == data.token.section_id)
                            {
                                content += `<button class="btn btn-sm btn-success" style="margin-right:3px">${data.services[key]}</button>`;
                            }
                            else
                            {
                                content += `<button class="btn btn-sm btn-primary" style="margin-right:3px">${data.services[key]}</button>`;
                            }
                        }

                        content += `</center></div>`;
                    }                   

                    content +="<ul class=\"list-unstyled\">";
                    content += "<li><p id=\"token-headr\"><strong class=\"text-success h3\" id=\"token-serial\">"+data.serial+"</strong> person left</p></li>";
                    content += "<li><p><strong class=\"text-success h4\">Approximate waiting time: <b> <span class=\"text-danger\" id=\"apx_time\">"+data.tokenInfo.aprx_time+"</span> </b> minutes</strong></p></li>";
                    content += "<li><strong>{{ trans('app.department') }} </strong>"+data.token.department+"</li>";
                    content += "<li><strong>{{ trans('app.service') }} </strong>"+data.token.section+"</li>";
                    content += "<li><strong>{{ trans('app.counter') }} </strong>"+data.token.counter+"</li>";
                    content += "<li><strong>{{ trans('app.officer') }} </strong>"+data.token.firstname+' '+data.token.lastname+"</li>";
                    content += "<li><strong>{{ trans('app.date') }} </strong>"+data.token.created_at+"</li>";
                    content += "</ul>";
                    content += "</div>";
                    
                    // print 
                    // printThis(content);
                    $("#screen-content").html(content);
                    // $("#getTokenModal").modal('show');

                    let serialInerval = setInterval(() => {
                        count_serialNumber(data.token);
                    }, 1000*10);

                    setTimeout(() => {
                        tokenRefresh(data.token);
                    }, 1000*10);


                    $("input[name=client_mobile]").val("");
                    $("textarea[name=note]").val("");
                    $('.modal button[type=submit]').addClass('hidden');
                }
                else
                {
                    $("input[name=client_mobile]").val(data.phone);
                    alert(data.exception);
                }
            },
            error: function(xhr)
            {
                // console.log(xhr);
                alert('wait...');
            }
        });
    }

    // $("body #toggleScreen").on("click", function(){
    //     if ( $("body #cm-menu").is(":hidden") )
    //     {
    //         $("body #cm-menu").show();
    //         $("body #cm-header").show();
    //         $("body .cm-footer").removeClass('hide');
    //         $("body.cm-1-navbar #global").removeClass('p-0');
    //         $("body .container-fluid").removeClass('m-0 p-0');
    //         $("body .panel").removeClass('m-0');
    //         $("body #toggleScreenArea #screen-note").show();
    //         $("body .panel-heading h3").text("{{ trans('app.auto_token') }}");

    //         $("body #toggleScreenArea #screen-content").attr({'style': ''});
    //         $("body #toggleScreen").html('<i class="fa fa-arrows-alt"></i>');
    //     }
    //     else
    //     {
    //         $("body #cm-menu").hide();
    //         $("body #cm-header").hide();
    //         $("body .cm-footer").addClass('hide');
    //         $("body.cm-1-navbar #global").addClass('p-0');
    //         $("body .container-fluid").addClass('m-0 p-0');
    //         $("body .panel").addClass('m-0');
    //         $("body .panel-heading h3").text($('.cm-navbar>.cm-flex').text());

    //         $("body #toggleScreenArea #screen-note").hide(); 
    //         $("body #toggleScreenArea #screen-content").attr({'style': 'width:100%;text-align:center'});
    //         $("body #toggleScreen").html('<i class="fa fa-arrows"></i>');
    //     }
    // });
 

    // $('body').on("keydown", function (e) { 
    //     var key = e.key;
    //     var code = e.keyCode; 
  
    //     if ($('.modal.in').length == 0 && '{{$display->keyboard_mode}}'==1 && ((code >= 48 && code <=57) ||  (code >= 96 && code <=105) || (code >= 65 && code <=90)))
    //     {
    //         var keyList = '<?= $keyList; ?>';
    //         $.each(JSON.parse(keyList), function (id, obj) {
    //             if (obj.key == key) {
    //                 // check form and ajax submit
    //                 @if($display->sms_alert || $display->show_note)
    //                     var modal = $('#tokenModal');
    //                     modal.modal('show');
    //                     modal.find('input[name=department_id]').val(obj.department_id);
    //                     modal.find('input[name=counter_id]').val(obj.counter_id);
    //                     modal.find('input[name=user_id]').val(obj.user_id);
    //                     modal.find("input[name=client_mobile]").val("");
    //                     modal.find("textarea[name=note]").val("");
    //                     modal.find('.modal button[type=submit]').addClass('hidden');
    //                 @else
    //                     var formData = new FormData();
    //                     formData.append("department_id", obj.department_id);
    //                     formData.append("counter_id", obj.counter_id);
    //                     formData.append("user_id", obj.user_id);
    //                     ajax_request(formData);
    //                     return false;
    //                 @endif
    //             }
    //         });
    //     }
    // });


    function count_serialNumber(tokenInfo)
    {
        $.ajax({
            url:"{{route('guest.serial')}}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            cache: false,
            data:  {
                departmentId: tokenInfo.department_id,
                counterId: tokenInfo.counter_id,
                companyId: tokenInfo.company_id,
                userId: tokenInfo.user_id,
                rowId: tokenInfo.id,
                mobile: tokenInfo.client_mobile,
                companyName: tokenInfo.title,
            },
            success: (response) => {
                let tokenSerial = response.data.serial;
                let position = response.data.position;
                let avg_time = response.data.avg_time;

                
                if(position > 1){
                    $("#token-serial").text(tokenSerial);
                    $("#apx_time").html(avg_time);

                    if(position == 2)
                    {
                        $("#token-headr").html("<strong style=\"color:white;background-color:green;padding:6px 10px\">Next is your turn</strong>");
                        $("#apx_time").html(avg_time);
                    }

                }else if(position == 1){
                    $("#token-headr").html("<strong style=\"color:white;background-color:red;padding:6px 10px\">Now your turn</strong>");
                    $("#apx_time").html("0");
                }else if(position == 0){
                    $("#token-headr").html("<strong style=\"color:white;background-color:green;padding:6px 10px\">Thank you for staying with us</strong>");
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
}(jQuery));
</script>

<script>
    let tokenRefresh = (token) => {
        console.log(token);

        $.ajax({
            url: "{{route('qr.token.refresh')}}",
            type: "POST",
            data:{
                "_token": "{{csrf_token()}}",
                token: token
            },
            success: (data) => {
                console.log(data);

                if (data.status)
                {
                    var content = "<style type=\"text/css\">@media print {"+
                        "html, body {display:block;margin:0!important; padding:0 !important;overflow:hidden;display:table;}"+
                        ".receipt-token {width:100vw;height:100vw;text-align:center}"+
                        ".receipt-token h4{margin:0;padding:0;font-size:7vw;line-height:7vw;text-align:center}"+
                        ".receipt-token h1{margin:0;padding:0;font-size:15vw;line-height:20vw;text-align:center}"+
                        ".receipt-token ul{margin:0;padding:0;font-size:7vw;line-height:8vw;text-align:center;list-style:none;}"+
                        "}</style>";

                    content += "<div class=\"receipt-token\">";
                    content += "<h4>"+data.title+"</h4>";
                    content += "<h1>"+data.token.token_no+"</h1>";

                    if(data.services != null)
                    {
                        content += `<div style="display:block;margin-bottom:10px"><center>`;
                        
                        for(key in data.services)
                        {
                            if(key == data.token.section_id)
                            {
                                content += `<button class="btn btn-sm btn-success" style="margin-right:3px">${data.services[key]}</button>`;
                            }
                            else
                            {
                                content += `<button class="btn btn-sm btn-primary" style="margin-right:3px">${data.services[key]}</button>`;
                            }
                        }

                        content += `</center></div>`;
                    }                   

                    content +="<ul class=\"list-unstyled\">";
                    // content += "<li><p id=\"token-headr\"><strong class=\"text-success h3\" id=\"token-serial\">"+data.serial+"</strong> person left</p></li>";
                    // content += "<li><p><strong class=\"text-success h4\">Approximate waiting time: <b> <span class=\"text-danger\" id=\"apx_time\">"+data.tokenInfo.aprx_time+"</span> </b> minutes</strong></p></li>";
                    content += "<li><strong>{{ trans('app.department') }} </strong>"+data.token.department+"</li>";
                    content += "<li><strong>{{ trans('app.service') }} </strong>"+data.token.section+"</li>";
                    content += "<li><strong>{{ trans('app.counter') }} </strong>"+data.token.counter+"</li>";
                    content += "<li><strong>{{ trans('app.officer') }} </strong>"+data.token.firstname+' '+data.token.lastname+"</li>";
                    content += "<li><strong>{{ trans('app.date') }} </strong>"+data.token.created_at+"</li>";
                    content += "</ul>";
                    content += "</div>";
                    
                    // print 
                    $("#screen-content").html(content);
                }
                else
                {
                    var content = "<style type=\"text/css\">@media print {"+
                        "html, body {display:block;margin:0!important; padding:0 !important;overflow:hidden;display:table;}"+
                        ".receipt-token {width:100vw;height:100vw;text-align:center}"+
                        ".receipt-token h4{margin:0;padding:0;font-size:7vw;line-height:7vw;text-align:center}"+
                        ".receipt-token h1{margin:0;padding:0;font-size:15vw;line-height:20vw;text-align:center}"+
                        ".receipt-token ul{margin:0;padding:0;font-size:7vw;line-height:8vw;text-align:center;list-style:none;}"+
                        "}</style>";

                    content += "<div class=\"receipt-token\">";
                    content += "<h4>"+data.title+"</h4>";
                    content += "<h1>"+data.token.token_no+"</h1>";
                    content += "<div><h1>"+data.message+"</h1></div>";

                    $("#screen-content").html(content);
                }

                setTimeout(() => {
                    tokenRefresh(data.token);
                }, 1000*10);
            },
            error: (error) => {
                console.log(error);
            }
        });
    }
</script>
@endpush
 
 