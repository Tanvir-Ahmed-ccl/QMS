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
                        <h1>Stripe</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="active">Stripe</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive text-nowrap">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Payment#</th>
                                    <th>Payment Mode</th>
                                    <th>Transaction</th>
                                    <th>Customer</th>
                                    <th>Fee</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $key => $row)
                                <tr>
                                    <td>{{ __(++$key) }}</td>
                                    <td>{{ __($row->payment_method) }}</td>
                                    <td>{{ __($row->balance_transaction) }}</td>
                                    <td>{{ __($row->user->email ?? '') }}</td>
                                    <td>{{ __($row->currency) }} {{ __($row->amount) }}</td>
                                    <td>{{ __(date("d-m-Y", strtotime($row->created_at))) }}</td>                                   
                                </tr>
                                @empty
                                <tr align="center">
                                    <td colspan="6">Record Not Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')

    <script>
        let EditConfirm = (KEY) => {
            swal({
                title: "Are you sure?",
                text: "Do you want to edit this records?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'users/edit/'+KEY;
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
        }

        let DeleteConfirm = (KEY) => {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'users/deactivate/'+KEY;
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.3/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
      } );
    </script>
@endpush