@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endpush

@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Members</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            @foreach ($members as $key => $user)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive text-nowrap">
                        <div class="row justify-content-center">
                            <div class="text-center">
                                <img src="{{ asset($user->image) }}" title="{{ __($user->name) }}" alt="Image" class="img-fluid mx-auto rounded-circle" width="90">
                                <!-- short info -->
                                <div class="my-3">
                                    <h5><b>{{ __($user->name) }}</b></h5>
                                    <small class="text-muted">{{ __($user->email) }}</small>
                                    <br>
                                    <small class="text-muted">{{ __($user->phone) }}</small>
                                </div>
                                
                                <!-- //. short info -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

