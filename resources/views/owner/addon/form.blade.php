@extends('owner.layouts.app')


@section('content')
 <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Addon</h1>
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
                <form action="{{route('addon.update')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="addonId" value="{{$row->id}}">

                    <div class="mb-3">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$row->title}}" required>
                    </div>


                    <div class="mb-3">
                        <label for="">Price</label>
                        <input type="text" name="price" class="form-control" value="{{$row->price}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Limitation</label>
                        <input type="text" name="limitation" class="form-control" value="{{$row->limitation}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="10">{{$row->description}}</textarea>
                    </div>

                    <button class="btn btn-primary my-4">Save</button>
                </form>
           </div>
        </div>
            <!-- //. Row -->
    </div><!-- .animated -->
</div><!-- .content -->
@endsection
