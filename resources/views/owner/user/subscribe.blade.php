@extends('admin.layouts.app')


@section('content')
<div class="breadcrumbs">
    <a href="{{ url()->previous() }}" class="btn-sm btn-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
        </svg>
    </a>
</div>

<div class="content">
    <div class="animated fadeIn">
        <!-- Row -->
        <div class="row mt-3 justify-content-center align-items-center ">
           <div class="col-md-8">
               <div class="card">
                <div class="card-body">
                     <form action="{{ route('owner.user.subscription.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key" value="{{ $user->id }}">

                        
                        <div class="mb-3">
                            <label for="">Subscription Plan</label>
                            <select name="plan_id" class="form-control" id="">
                                <option value="" selected>Select a plan</option>
                                @foreach ($plans as $row)
                                <option value="{{ $row->id }}">{{ $row->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary" type="submit">Update</button>
                    </form>
                </div>
               </div>
           </div>
        </div>
            <!-- //. Row -->
    </div><!-- .animated -->
</div><!-- .content -->
@endsection
