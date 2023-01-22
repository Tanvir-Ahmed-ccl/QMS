@extends('owner.layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">
<style>
    .iti{
        display: block !important;
    }
</style>
@endpush
@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Profile</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('owner/dashboard') }}">Home</a></li>
                            <li class="active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <!-- Row -->
        <div class="row mt-3 justify-content-center align-items-center">
           <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('owner.profile') }}" method="POST" enctype="multipart/form-data" id="updateForm">
                            @csrf
                            <input type="hidden" name="update_key" value="{{ __(Auth::guard('owner')->id()) }}">
                            <div class="row mb-3 px-3">
                                <div class="col mb-3">
                                    <img src="{{ asset('owner/profile.jpg') }}" alt="Company Image" class="img-fluid rounded-circle d-block m-auto" width="100">
                                </div>                        
                            </div>

                            <div class="mb-3">
                                <label for="">Full Name<span class="text-danger fs-5">*</span></label>
                                <input type="text" name="name" id="userName" class="form-control" value="{{ __(Auth::guard('owner')->user()->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Email<span class="text-danger fs-5">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::guard('owner')->user()->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="">Phone<span class="text-danger fs-5">*</span></label><br>
                                <input type="tel" name="phone" id="mobile" class="form-control" value="{{ Auth::guard('owner')->user()->phone }}">
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary btn-block">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
           </div>            
        </div>
        <!-- //. Row -->


        <div class="row mt-3 justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('owner.password') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="update_key" value="{{ __(Auth::guard('owner')->id()) }}">
                            
                            <h3>Update Password</h3><br>

                            <div class="mb-3">
                                <label for="">Current Password<span class="text-danger fs-5">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Minimum 8 characters">
                                    <span class="input-group-text border-left-0 rounded-0 bg-white" id="show_pass_btn" onclick="showPass('#show_pass_btn', '#current_password')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">New Password<span class="text-danger fs-5">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Minimum 8 characters">
                                    <span class="input-group-text border-left-0 rounded-0 bg-white" id="show_new_pass_btn" onclick="showPass('#show_new_pass_btn', '#password')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </span>
                                </div>

                                @error('password')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="">Confirm Password<span class="text-danger fs-5">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Minimum 8 characters">
                                    <span class="input-group-text border-left-0 rounded-0 bg-white" id="show_new_pass_btn2" onclick="showPass('#show_new_pass_btn2', '#confirm_password')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary btn-block">Update Password</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        /** Show Password */
        showPass = (targetID, targetfield = '#password') => {

            var fieldType = $(targetfield).attr('type');
            
            if(fieldType === 'password')
            {
                $(targetfield).attr('type', 'text');
                $(targetID).empty();
                $(targetID).append('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">\
                                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>\
                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>\
                                    </svg>');
            }
            else
            {
                $(targetfield).attr('type', 'password');

                $(targetID).empty();
                $(targetID).append('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">\
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>\
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>\
                                    </svg>');
            }
        }
    </script>

    <script src="{{ asset('intelInput/jquery.min.js') }}"></script>
    <script src="{{ asset('intelInput/script.min.js') }}"></script>
    <script>
        $(function() {
            $("#mobile").intlTelInput({
                allowExtensions: true,
                autoFormat: false,
                autoHideDialCode: false,
                autoPlaceholder: false,
                defaultCountry: "gh",
                // ipinfoToken: "yolo",
                nationalMode: false,
                numberType: "MOBILE",
                preferredCountries: ['gh', 'us'],
                preventInvalidNumbers: true,
            });
        });
    </script>
@endpush