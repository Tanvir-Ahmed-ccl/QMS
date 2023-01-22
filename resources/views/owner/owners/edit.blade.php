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
    <a href="{{ url()->previous() }}" class="btn-sm btn-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
        </svg>
    </a>
</div>

<div class="content">
    <div class="animated fadeIn">
        <!-- Row -->
        @if (isset($row))
        <div class="row mt-3 justify-content-center align-items-center">
           <div class="col-md-5">
                <form action="{{ route('owner.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $row->id }}">

                    
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $row->name }}">
                    
                        @error('name')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $row->email }}">
                    
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">Phone</label>
                        <input type="tel" class="form-control" name="phone" id="mobile" value="{{ $row->phone }}">
                    
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">password</label>
                        <input type="passoword" class="form-control" name="password" placeholder="At least 8 digit">
                    
                        @error('password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
           </div>
        </div>
        @else
        <div class="row mt-3 justify-content-center align-items-center">
           <div class="col-md-5">
                <form action="{{ route('owner.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                        @error('name')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" >
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">Phone</label>
                        <input type="tel" class="form-control" name="phone" id="mobile" value="">
                    
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">password</label>
                        <input type="passoword" class="form-control" name="password" placeholder="At least 8 digit">
                    
                        @error('password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">SAVE</button>
                </form>
           </div>
        </div>
        @endif
            <!-- //. Row -->
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')
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
