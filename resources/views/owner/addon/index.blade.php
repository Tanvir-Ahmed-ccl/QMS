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
                        <h1>Addons</h1>
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
            <div class="col card card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>price</th>
                            <th>Limitation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $key => $row)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->price}} / month</td>
                                <td>{{$row->limitation}} days</td>
                                <td>
                                    <a href="#" class="btn btn-primary"
                                        onclick="if(confirm('Are you sure?')){location.replace('{{route('addon.edit', $row->id)}}')}"
                                    >Update</a>
                                </td>
                            </tr>
                        @empty
                            <tr align="center">
                                <td colspan="3">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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