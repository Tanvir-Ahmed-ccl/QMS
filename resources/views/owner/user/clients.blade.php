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
                        <h1>Clients</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="active"><a href="{{ url()->previous() }}">Users</a></li>
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
           
            @foreach ($clients as $key => $user)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive text-nowrap">
                        <div class="row justify-content-center">
                            <div class="text-center">
                                <img src="{{ asset($user->image) }}" title="{{ __($user->company_name) }}" alt="Image" class="img-fluid mx-auto rounded-circle" width="90">
                                <!-- short info -->
                                <div class="my-3">
                                    <h5><b>{{ __($user->client_name) }}</b></h5>
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

@push('script')
    <script src="{{ asset('assets/admin/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/init/datatables-init.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
          $('#dataTable').DataTable();
      } );
    </script>
@endpush