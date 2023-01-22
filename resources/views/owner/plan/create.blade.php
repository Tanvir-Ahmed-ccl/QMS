@extends('admin.layouts.app')


@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>New Subscription Plans</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="active">New Plans</li>
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
           <div class="col-md-8">
                @if (isset($plan))
                <form action="{{ route('owner.plan.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $plan->id }}">
                    <div class="mb-3">
                        <label for="">Plan Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $plan->title }}">
                        @error('title')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="details" id="ckEditor" class="form-control" id="" cols="30" rows="10">{!! $plan->details !!}</textarea>
                        @error('details')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Price per month</label>
                        <input type="text" name="price_per_month" class="form-control" value="{{ $plan->price_per_month }}">
                        @error('price_per_month')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Maximum SMS Limit</label>
                        <input type="text" name="sms_limit" class="form-control" value="{{ $plan->sms_limit }}">
                        @error('sms_limit')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="">Maximum Display Limit</label>
                        <input type="text" name="display_limit" class="form-control" value="{{ $plan->display_limit }}">
                        @error('display_limit')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div> --}}


                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
                @else
                <form action="{{ route('owner.plan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="">Plan Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @error('title')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="details" id="ckEditor" class="form-control" id="" cols="30" rows="10">{{ old('details') }}</textarea>
                        @error('details')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Price per month</label>
                        <input type="text" name="price_per_month" class="form-control" value="{{ old('price_per_month') }}">
                        @error('price_per_month')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Maximum SMS Limit</label>
                        <input type="text" name="sms_limit" class="form-control" value="{{ old('sms_limit') }}">
                        @error('sms_limit')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="">Maximum Display Limit</label>
                        <input type="text" name="display_limit" class="form-control" value="{{ old('display_limit') }}">
                        @error('display_limit')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div> --}}


                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
                @endif
           </div>
        </div>
            <!-- //. Row -->
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')
    <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('ckEditor', {
            width: '100%',
            height: 200,
            removeButtons: 'PasteFromWord'
        });
    </script>
@endpush