@extends('layouts.backend')
@section('title', 'Auto Token Setting')

@section('content')
<div class="panel panel-primary">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 text-left">
                <h3>{{ trans('app.auto_token_setting') }}</h3>
            </div> 
        </div>
    </div>

    <div class="panel-body">
        <!-- setting form -->
        <div class="col-sm-4">  
            {{ Form::open(['url' => 'admin/token/setting']) }}

                <div class="form-group @error('department_id') has-error @enderror">
                    <label for="department_id">{{ trans('app.department') }} <i class="text-danger">*</i></label><br/>
                    {{-- {{ Form::select('department_id', $departmentList, null, ['placeholder' => 'Select Option', 'class'=>'select2 form-control', 'required'=>'required', 'onchange' => 'loadCounterAndOfficer(this.value)']) }}<br/> --}}
                    <select name="department_id" class="select2 form-control" placeholder="Select Option" onchange="loadCounterAndOfficer(this.value)">
                        <option value="" selected>Select Option</option>
                        @foreach ($departmentList as $key => $item)
                            <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('department_id') }}</span>
                </div> 

                <div class="form-group @error('section_id') has-error @enderror">
                    <label for="section_id">{{ trans('app.service') }} <i class="text-danger">*</i></label><br/>
                    <select name="section_id[]" class="form-control" placeholder="Select Option" multiple required>
                        @foreach($sections as $key => $val)
                        <option value="{{$key}}" @if(old('section_id')) {{ (in_array($key, old('section_id')) ? 'selected' : '') }} @endif >{{$val}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('section_id') }}</span>
                </div> 

                {{-- <div class="form-group @error('counter_id') has-error @enderror">
                    <label for="counter">{{ trans('app.counter') }} <i class="text-danger">*</i></label><br/>
                    {{ Form::select('counter_id', $countertList, null, ['placeholder' => 'Select Option', 'class'=>'select2 form-control', 'required'=>'required']) }}<br/>
                    <span class="text-danger">{{ $errors->first('counter_id') }}</span> 
                </div>  --}}

                <div class="form-group @error('counter_id') has-error @enderror">
                    <label for="counter">{{ trans('app.counter') }} <i class="text-danger">*</i></label><br/>
                    {{ Form::select('counter_id', [], null, ['placeholder' => 'Select Option', 'class'=>'select2 form-control', 'id'=>'ajax_counter', 'required'=>'required']) }}<br/>
                    <span class="text-danger">{{ $errors->first('counter_id') }}</span>
                </div> 


                <div class="form-group @error('user_id') has-error @enderror">
                    <label for="officer">{{ trans('app.officer') }} <i class="text-danger">*</i></label><br/>
                    {{ Form::select('user_id', [], null, ['placeholder' => 'Select Option', 'class'=>'select2 form-control', 'id'=>'ajax_officer', 'required'=>'required']) }}<br/>
                    <span class="text-danger">{{ $errors->first('user_id') }}</span>
                </div> 
                
                <div class="btn-group">
                    <button type="reset" class="btn btn-primary">{{ trans('app.reset') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('app.save') }}</button> 
                </div>
            
            {{ Form::close() }}
        </div>

        <!-- display setting option -->
        <div class="col-sm-8">
            <table class="display table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>{{ trans('app.department') }}</th>
                        <th>{{ trans('app.service') }}</th>
                        <th>{{ trans('app.counter') }}</th>
                        <th>{{ trans('app.officer') }}</th> 
                        <th>{{ trans('app.action') }}</th>
                    </tr>
                </thead> 
                <tbody>

                    @if (!empty($tokens))
                        <?php $sl = 1 ?>
                        @foreach ($tokens as $token)
                            <tr>
                                <td>{{ $sl++ }}</td> 
                                <td>{{ $token->department }}</td>
                                <td>
                                    @foreach (services($token->services, "array") as $item)
                                        <span class="badge" style="background-color: green; margin-right:2px">{{$item}}</span>
                                    @endforeach
                                </td>
                                <td>{{ $token->counter }}</td>
                                <td>{{ $token->firstname }} {{ $token->lastname }}</td>
                                <td>
                                    <div class="btn-group">   
                                        <a href="{{ url("admin/token/setting/delete/$token->id") }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" title="Delete"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr> 
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div> 
</div>  
@endsection

 

@push('scripts')
    <script>
        function loadCounterAndOfficer(department){
            console.log(department);

            $.ajax({
                "url": "{{route('load.counter.from.department')}}",
                "type": "GET",
                "data": {
                    department: department,
                    company: '{{getCompanyDetails(Auth::id())->id}}'
                },
                'success': function(resp){
                    $("#ajax_counter").html(resp.counterOptions);
                    $("#ajax_officer").html(resp.officerOptions);
                },
                "error": function(error){
                    console.log(error.responseJSON.message);
                }
            })
        }
    </script>
@endpush    