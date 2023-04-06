@extends('owner.layouts.app')

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
                        <h1>Package</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <a href="{{ route('sms.create') }}" class="btn btn-primary">New Plan</a>
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
            @forelse ($data['plans'] as $plan)
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white">
                        <h5 class="text-center mb-0">
                            <b>{{__($plan->title)}}</b>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        
                        <div class="border-bottom mb-3 py-3 text-center">
                            <h3 class="m-0"><b>{{\App\Models\AppSettings::first()->CURRENCY_SIGN}} {{__($plan->price)}}</b><small>/mo</small></h3>
                            <p class="text-muted m-0">Billed Monthly</p>
                        </div>

                        <div class="px-5 mb-3 text-center">SMS : {!! $plan->sms_limit !!}</div>
                        <div class="px-5 mb-3">{!! $plan->description !!}</div>

                        <div class="text-center mb-3">
                            <a href="{{ route('sms.edit', [$plan->id]) }}" class="btn btn-info">Update</a>
                            <a href="javascript::" onclick="if(confirm('Are you sure? Do you want to delete this record?')){ location.replace('/owner/sms/destroy/{{$plan->id}}'); }" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted">No Plans Found</div>
            @endforelse
        </div>
            <!-- //. Row -->
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')
    <script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/init/datatables-init.js"></script>
@endpush