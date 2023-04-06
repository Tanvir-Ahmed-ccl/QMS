@extends('layouts.backend')
@section('title', trans('Create new Advertisement'))

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-8 text-left">
                <h3>Create new Advertisement</h3>
            </div>
            <div class="col-sm text-right">
                <a 
                    href="{{route('advertisement.index')}}" 
                    class="btn btn-primary"
                    title="Back to List"
                >
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body" id="printThis"> 
        <div class="row">
            
            <div class="col-sm-12 panel-body table-responsive">
                <form action="{{route('advertisement.store')}}" class="col-md-7 col-sm-8" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group @error('title') has-error @enderror">
                        <label for="time">Title<i class="text-danger">*</i> </label>
                        <input type="text" name="title" class="form-control" placeholder="" required> 
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    </div>

                    <div class="form-group @error('link') has-error @enderror">
                        <label for="time">Link </label>
                        <input type="text" name="link" class="form-control" placeholder="https://xyz.com"> 
                        <span class="text-danger">{{ $errors->first('link') }}</span>
                    </div>

                    <div class="form-group @error('banner') has-error @enderror">
                        <label for="time">Banner <i class="text-danger">*</i></label>
                        <input type="file" name="banner" class="form-control" required> 
                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                    </div>


                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div> 
</div>  
@endsection

 

