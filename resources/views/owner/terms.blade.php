@extends('owner.layouts.app')


@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Terms of Service</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('owner/dashboard') }}">Home</a></li>
                            <li class="active">Terms of Service</li>
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

                        <form action="{{route('owner.terms.update')}}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="">Terms of service</label>
                                <textarea name="terms" id="terms">{!! $terms !!}</textarea>
                            </div>

                            <button class="btn btn-outline-primary">Save</button>
                        </form>
                    </div>
                </div>
           </div>            
        </div>
        <!-- //. Row -->

    </div><!-- .animated -->
</div><!-- .content -->

<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
     CKEDITOR.replace( 'terms' );
</script>
@endsection
