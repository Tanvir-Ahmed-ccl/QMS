@extends('layouts.backend')
@section('title', trans('app.appointment'))

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-8 text-left">
                <h3>Settings</h3>
            </div>
        </div>
    </div>

    <div class="panel-body" id="printThis"> 
        <div class="row">
            
            <div class="col-sm-12 panel-body table-responsive">
            {{ Form::open(['url' => 'admin/book/settings', 'files' => true, 'class'=>'col-md-7 col-sm-8']) }}

                <div class="form-group @error('time') has-error @enderror">
                    <label for="time">Alert A User Before Appointment<i class="text-danger">*</i> (In Minutes)</label>
                    <input type="number" name="time" id="time" class="form-control" value="{{ (isset($time)) ? $time->time : old('time') }}" placeholder="2"> 
                    <span class="text-danger">{{ $errors->first('time') }}</span>
                </div>


                <button class="btn btn-primary">Save</button>

            {{ Form::close() }}
            </div>
        </div>
    </div> 
</div>  
@endsection

 

