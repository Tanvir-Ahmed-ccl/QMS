@extends('layouts.backend')
@section('title', trans('app.counter_list'))

@section('content')
<div class="panel panel-primary">

    <div class="panel-heading">
        <ul class="row list-inline m-0">
            <li class="col-xs-10 p-0 text-left">
                <h3>{{ trans('Sections') }}</h3>
            </li>             
            {{-- <li class="col-xs-2 p-0 text-right">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#infoModal">
                  <i class="fa fa-info-circle"></i>
                </button>
            </li>  --}}
        </ul>
    </div>

    <div class="panel-body">
        <div class="col-sm-12 table-responsive">
            <table class="datatable table table-bordered" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('Section') }}</th>
                        <th>{{ trans('app.created_at') }}</th>
                        <th>{{ trans('app.updated_at') }}</th>
                        <th>{{ trans('app.status') }}</th>
                        <th width="80"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead> 
                <tbody>

                    @if (!empty($sections))
                        <?php $sl = 1 ?>
                        @foreach ($sections as $section)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ $section->name }}</td>
                                <td>{{ (!empty($section->created_at)?date('j M Y h:i a',strtotime($section->created_at)):null) }}</td>
                                <td>{{ (!empty($section->updated_at)?date('j M Y h:i a',strtotime($section->updated_at)):null) }}</td>
                                <td>{!! (($section->status==1)?"<span class='label label-success'>". trans('app.active') ."</span>":"<span class='label label-dander'>". trans('app.deactive') ."</span>") !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ url("admin/section/edit/$section->id") }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="{{ url("admin/section/delete/$section->id") }}" class="btn btn-danger btn-sm" onclick="return confirm('{{ trans("app.are_you_sure") }}')"><i class="fa fa-times"></i></a>
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

 
