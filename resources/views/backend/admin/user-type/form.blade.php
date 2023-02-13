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
        {{ Form::open(['url' => 'admin/user-type/create', 'files' => true]) }}

            <div class="form-group @error('name') has-error @enderror">
                <label for="name">{{ trans('User Type') }} <i class="text-danger">*</i></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="{{ trans('User Type') }}" value="{{ old('name') }}" required> 
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>


            <hr>
            <h4>User Access</h4>
            <?php $i = 0; ?>
            <div class="row" style="margin-bottom: 15px; justify-content: center">

                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Location</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="location_read" value="1" type="checkbox" id="location_read" {{ (issetAccess(Auth::user()->user_role_id)->location['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="location_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="location_write" value="1" type="checkbox" id="location_write" {{ (issetAccess(Auth::user()->user_role_id)->location['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="location_write">Write</label>
                    </div>
                </div>

                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Section</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="section_read" value="1" type="checkbox" id="section_read" {{ (issetAccess(Auth::user()->user_role_id)->section['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="section_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="section_write" value="1" type="checkbox" id="section_write" {{ (issetAccess(Auth::user()->user_role_id)->section['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="section_write">Write</label>
                    </div>
                </div>


                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Counter</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="counter_read" value="1" type="checkbox" id="counter_read" {{ (issetAccess(Auth::user()->user_role_id)->counter['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="counter_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="counter_write" value="1" type="checkbox" id="counter_write" {{ (issetAccess(Auth::user()->user_role_id)->counter['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="counter_write">Write</label>
                    </div>
                </div>


                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. User Type</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="user_type_read" value="1" type="checkbox" id="user_type_read" {{ (issetAccess(Auth::user()->user_role_id)->user_type['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="user_type_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="user_type_write" value="1" type="checkbox" id="user_type_write" {{ (issetAccess(Auth::user()->user_role_id)->user_type['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="user_type_write">Write</label>
                    </div>
                </div>


                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Users</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="users_read" value="1" type="checkbox" id="users_read" {{ (issetAccess(Auth::user()->user_role_id)->users['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="users_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="users_write" value="1" type="checkbox" id="users_write" {{ (issetAccess(Auth::user()->user_role_id)->users['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="users_write">Write</label>
                    </div>
                </div>

                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. SMS</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="sms_read" value="1" type="checkbox" id="sms_read" {{ (issetAccess(Auth::user()->user_role_id)->sms['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="sms_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="sms_write" value="1" type="checkbox" id="sms_write" {{ (issetAccess(Auth::user()->user_role_id)->sms['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="sms_write">Write</label>
                    </div>
                </div>


                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Active/Current Token</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_active_token_all" value="1" type="checkbox" id="token_active_token_all" {{ (issetAccess(Auth::user()->user_role_id)->token['active_token']['all_token'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_active_token_all">All Token</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_active_token_own" value="1" type="checkbox" id="token_active_token_own" {{ (issetAccess(Auth::user()->user_role_id)->token['active_token']['own_token'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_active_token_own">Own Token</label>
                    </div>


                    {{-- <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_active_token_read" value="1" type="checkbox" id="token_active_token_read" {{ (issetAccess(Auth::user()->user_role_id)->token['active_token']['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_active_token_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_active_token_write" value="1" type="checkbox" id="token_active_token_write" {{ (issetAccess(Auth::user()->user_role_id)->token['active_token']['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_active_token_write">Write</label>
                    </div> --}}
                </div>

               <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Token Report</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_token_report_read" value="1" type="checkbox" id="token_token_report_read" {{ (issetAccess(Auth::user()->user_role_id)->token['token_report']['read'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_token_report_read">Read</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_token_report_write" value="1" type="checkbox" id="token_token_report_write" {{ (issetAccess(Auth::user()->user_role_id)->token['token_report']['write'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_token_report_write">Write</label>
                    </div>
                </div>

                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Token</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_auto_token" value="1" type="checkbox" id="token_auto_token" {{ (issetAccess(Auth::user()->user_role_id)->token['auto_token'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_auto_token">Auto Token</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_manual_token" value="1" type="checkbox" id="token_manual_token" {{ (issetAccess(Auth::user()->user_role_id)->token['manual_token'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_manual_token">Manual Token</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_performance_report" value="1" type="checkbox" id="token_performance_report" {{ (issetAccess(Auth::user()->user_role_id)->token['performance_report'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_performance_report">Performance Report</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="token_auto_token_setting" value="1" type="checkbox" id="token_auto_token_setting" {{ (issetAccess(Auth::user()->user_role_id)->token['auto_token_setting'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="token_auto_token_setting">Auto Token Setting</label>
                    </div>
                </div>


                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Settings</label>
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="setting_app_setting" value="1" type="checkbox" id="setting_app_setting" {{ (issetAccess(Auth::user()->user_role_id)->setting['app_setting'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="setting_app_setting">App Settings</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="setting_subsription" value="1" type="checkbox" id="setting_subsription" {{ (issetAccess(Auth::user()->user_role_id)->setting['subsription'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="setting_subsription">Subscription</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="setting_display_setting" value="1" type="checkbox" id="setting_display_setting" {{ (issetAccess(Auth::user()->user_role_id)->setting['display_setting'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="setting_display_setting">Display Settings</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="setting_profile_information" value="1" type="checkbox" id="setting_profile_information" {{ (issetAccess(Auth::user()->user_role_id)->setting['profile_information'] == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="setting_profile_information">Profile Information</label>
                    </div>
                    
                </div>


                <div class="col-md-3" style="margin-bottom: 20px">
                    <label style="margin-bottom: 10px">{{++$i}}. Others</label>
                    
                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="display" value="1" type="checkbox" id="display" {{ (issetAccess(Auth::user()->user_role_id)->display == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="display">Display</label>
                    </div>

                    <div class="form-check form-check-inline" style="margin-left: 30px">
                        <input class="form-check-input" name="message" value="1" type="checkbox" id="message" {{ (issetAccess(Auth::user()->user_role_id)->message == 1) ? 'checked' : '' }}>
                        <label style="margin-left: 10px; font-weight:normal" for="message">message</label>
                    </div>
                    
                </div>
            </div>
            <hr>

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