@extends('layouts.backend')
@section('title', trans('app.add_counter'))

@section('content')
<div class="panel panel-primary" id="printMe">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 text-left">
                <h3>{{ trans('app.new_service') }}</h3>
            </div> 
        </div>
    </div>

    <div class="panel-body"> 

        {{ Form::open(['url' => 'admin/section/create', 'class'=>'col-md-7 col-sm-8']) }}
     
            <div class="form-group @error('name') has-error @enderror">
                <label for="name">{{ trans('Name') }} <i class="text-danger">*</i></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="{{ trans('app.service_name') }}" value="{{ old('name') }}">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            

            <div class="form-group @error('status') has-error @enderror">
                <label for="status">{{ trans('app.status') }} <i class="text-danger">*</i></label>
                <div id="status"> 
                    <label class="radio-inline">
                        <input type="radio" name="status" value="1" {{ (old("status")==1)?"checked":"" }}> {{ trans('app.active') }}
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" value="0" {{ (old("status")==0)?"checked":"" }}> {{ trans('app.deactive') }}
                    </label> 
                </div>
            </div>

            <div class="form-group">
                <button class="button btn btn-info" type="reset"><span>{{ trans('app.reset') }}</span></button>
                <button class="button btn btn-success" type="submit"><span>{{ trans('app.save') }}</span></button>
            </div>

        {{ Form::close() }}

    </div>
</div> 
@endsection
