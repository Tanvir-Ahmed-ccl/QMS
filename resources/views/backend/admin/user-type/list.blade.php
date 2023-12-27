@extends('layouts.backend')
@section('title', trans('app.user_type'))
 

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <ul class="row list-inline m-0">
            <li class="col-xs-10 p-0 text-left">
                <h3>{{ trans('app.type_list') }}</h3>
            </li>
            <li class="col-xs-2 p-0 text-right">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#infoModal">
                  <i class="fa fa-info-circle"></i>
                </button>
            </li> 
        </ul>
    </div>

    <div class="panel-body table-responsive">
        <table class="dataTables-server table table-bordered" cellspacing="0">
            <thead>                   
                <tr>
                    <th>{{ trans('S.N') }}</th>
                    <th>{{ trans('app.user_type') }}</th>
                    <th>{{ trans('app.status') }}</th>  
                    <th>{{ trans('app.created_at') }}</th> 
                    <th>{{ trans('app.updated_at') }}</th>  
                    <th width="80"><i class="fa fa-cogs"></i></th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($userTypes as $key => $item)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            @if ($item->status==1)
                            <span class='label label-success'>{{ trans('app.active') }}</span>
                            @else
                            <span class='label label-danger'>{{ trans('app.deactive') }}</span>  
                            @endif
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <div class="btn-group">
                                <a href='{{ url("admin/user-type/edit/".$item->id) }}' class="btn btn-sm btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href='{{ url("admin/user-type/delete/".$item->id)}}' onclick="if(confirm('{{trans('app.are_you_sure')}}')){}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="infoModalLabel">{{ trans('app.note') }}</h4>
      </div>
      <div class="modal-body">
            <p><strong class="label label-warning"> Note 1 </strong> &nbsp;If you delete a User then, the related tokens are not calling on the Display screen. Because the token is dependent on User ID</p>
            <p><strong class="label label-warning"> Note 2 </strong> &nbsp;If you want to change a User name you must rename the User instead of deleting it. 
            </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
@endsection