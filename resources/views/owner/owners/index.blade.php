@extends('owner.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/datatable/dataTables.bootstrap.min.css') }}">
@endpush

@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-md-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Owners</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <a href="{{ route('owner.create') }}" class="btn btn-primary">New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <div class="row">
            @forelse ($owners as $key => $user)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card" style="height: 300px">
                    <div class="card-body">

                        <div class="row justify-content-center">
                            <div class="text-center">
                                <img src="{{ asset($user->photo ?? 'd/no-photo.jpg') }}" title="{{ __($user->name) }}" alt="Image" class="img-fluid mx-auto rounded-circle" style="height: 120px; width: 120px">
                                <!-- short info -->
                                <div class="my-3">
                                    <h5><b>{{ __($user->name) }}</b></h5>
                                    <small class="text-muted">{{ __($user->email) }}</small>
                                </div>
                                <div class="mt-3">
                                    <a  class="btn-sm btn-info m-1" type="button" href="{{ route('owner.create', [$user->id]) }}"> <i class="fa fa-edit"></i> </a>
                                    <a  class="btn-sm btn-info m-1" type="button" href="{{ route('owner.delete', [$user->id]) }}"> <i class="fa fa-trash"></i> </a>
                                    
                                    @if ($user->status == 1)
                                    <a class="btn-sm btn-info m-1" type="button" href="javascript::" title="Deactiavted Account" onclick="updateStatus('{{ $user->id }}')">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                    @else
                                    <a class="btn-sm btn-info m-1" type="button" href="javascript::" title="Actiavted Account" onclick="updateStatus('{{ $user->id }}')"> 
                                        <i class="fa fa-unlock"></i>
                                    </a>
                                    @endif
                                </div>
                                <!-- //. short info -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @empty

            <div class="col-12 mt-5 text-center">
                <h5><b>Not found</b></h5>
            </div>

            @endforelse

        </div>

        <!--    Pagination  -->
        <div class="row">
            <div class="col-12 text-right">
                @if ($owners->hasPages())
                    @if ($owners->onFirstPage())
                        <a class="btn-sm btn-primary disabled"><span>← Previous</span></a>
                    @else
                        <a class="btn-sm btn-primary" href="{{ $owners->previousPageUrl() }}" rel="prev">← Previous</a>
                    @endif

                    @if ($owners->hasMorePages())
                        <a class="btn-sm btn-primary" href="{{ $owners->nextPageUrl() }}" rel="next">Next →</a>
                    @else
                        <a class="btn-sm btn-primary disabled"><span>Next →</span></a>
                    @endif
                @endif
            </div>
        </div><!--    //. Pagination  -->
    </div><!-- .animated -->
</div><!-- .content -->
@endsection

@push('script')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>



        let EditConfirm = (KEY) => {
            swal({
                title: "Are you sure?",
                text: "You want to update the user's subscription.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'owner/delete/'+KEY;
                }
            });
        };

        let updateStatus = (KEY) => {
            swal({
                title: "Are you sure?",
                text: "Do you want to deactivate this user's account?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'owner/status/'+KEY;
                } else {
                    swal("The account is safe!");
                }
            });
        }
    </script>

@endpush