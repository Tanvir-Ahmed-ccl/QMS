@extends('owner.layouts.app')


@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>About</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('owner/dashboard') }}">Home</a></li>
                            <li class="active">About</li>
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
           <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('owner.about.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf                            

                            <div class="mb-3">
                                <label for="">About</label>
                                <textarea type="text" name="about_us">{!! \App\Models\AppSettings::first()->ABOUT_US_ONE !!}</textarea>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
           </div>            
        </div>
        <!-- //. Row -->

    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
      CKEDITOR.replace( 'about_us' );
    </script>
@endpush