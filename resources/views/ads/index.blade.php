@extends('layouts.backend')
@section('title', trans('app.advertisement'))

@section('content')
<div class="panel panel-primary">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-8 text-left">
                <h3>{{ trans('app.advertisement') }}</h3>
            </div>
            <div class="col-sm text-right">
                <a 
                    href="{{route('advertisement.create')}}" 
                    class="btn btn-primary"
                >
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="datatable table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Banner</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead> 
            <tbody>
               @foreach ($data['ads'] as $key => $ads)
                   <tr>
                        <td> {{++$key}} </td>
                        <td> {{$ads->title}} </td>
                        <td> {{$ads->link}} </td>
                        <td> 
                            <img src="{{asset($ads->images)}}" alt="banner {{$key}}" class="img-fluid" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success">Active</button>
                        </td>
                        <td>
                            <form action="{{route('advertisement.destroy', $ads->id)}}" method="POST" id="DeleteForm">
                                @method("DELETE")
                                @csrf
                            </form>
                            <a 
                                href="javascript::" 
                                class="btn btn-sm btn-danger" 
                                title="Delete"
                                onclick="if(confirm('Are You Sure?')){document.getElementById('DeleteForm').submit()}"
                            >
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                   </tr>
               @endforeach
        </table>
    </div> 
</div>  
@endsection