@extends('layouts.backend')
@section('title', "Add User Type")

@section('content')
<div class="panel panel-primary">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 text-left">
                <h3>{{ trans('Add User Type') }}</h3>
            </div> 
        </div>
    </div>

    <div class="panel-body"> 
        {{ Form::open(['url' => 'admin/user-type/create', 'files' => true, 'class'=>'col-md-7 col-sm-8']) }}

            <div class="form-group @error('name') has-error @enderror">
                <label for="name">{{ trans('User Type') }} <i class="text-danger">*</i></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="{{ trans('User Type') }}" value="{{ old('name') }}" required> 
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

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    //user form  
    var user_type       = $("#user_type");
    var user_department = $("#user_department");

    if ("{{ old('user_type') }}" == "1") {
            user_department.removeClass('hide');
    }
    
    user_type.on('change',function() {
        id = $(this).val();

        if (id == 1) {
            user_department.removeClass('hide');
        } else {
            user_department.addClass('hide');
        }
    });
});  
</script>
@endpush
 