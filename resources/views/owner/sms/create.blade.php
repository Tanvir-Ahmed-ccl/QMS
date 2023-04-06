@extends('owner.layouts.app')


@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>New Package</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="active">New Package</li>
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
                <form action="{{ route('sms.update', $plan->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $plan->id }}">
                    <div class="mb-3">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $plan->title }}">
                        @error('title')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="ckEditor" class="form-control" id="" cols="30" rows="10">{!! $plan->description !!}</textarea>
                        @error('description')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Price</label>
                        <input type="text" name="price" class="form-control" value="{{ $plan->price }}">
                        @error('price')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">SMS Limit</label>
                        <input type="text" name="sms_limit" class="form-control" value="{{ $plan->sms_limit }}">
                        @error('sms_limit')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
                @else
                <form action="{{ route('sms.store') }}" method="POST">
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
                        <textarea name="description" id="ckEditor" class="form-control" id="" cols="30" rows="10">{{ old('details') }}</textarea>
                        @error('description')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Price</label>
                        <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                        @error('price')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">SMS Limit</label>
                        <input type="text" name="sms_limit" class="form-control" value="{{ old('sms_limit') }}">
                        @error('sms_limit')
                            <b class="text-danger">{{ $message }}</b>
                        @enderror
                    </div>


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