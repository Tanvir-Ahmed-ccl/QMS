@extends('layouts.backend')
@section('title', trans('app.auto_token'))
@push('styles')
    <link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">
    <!-- Jquery  -->
    <style>
        .iti{
            display: block !important;
        }
    </style>
@endpush
@section('content')
<div class="panel panel-primary" id="toggleScreenArea">
    
    <div class="panel-body row">
      @foreach ($departmentList as $department) 
      <form action="{{ url('common/single-line-queue') }}" target="_blank">
        <input type="hidden" name="location" value="{{$department->department_id}}">
        <div class="col-lg-3">
          <button 
            type="submit" 
            class="px-5 btn-block btn btn-primary capitalize text-center"
          >
                  <h4>{{ $department->name }}</h4>
          </button>  
        </div>
      </form>
      @endforeach  
    </div> 
</div>  


@endsection
 
 