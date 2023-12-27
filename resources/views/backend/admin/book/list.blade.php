@extends('layouts.backend')
@section('title', trans('app.todays_token'))

@section('content')
<div class="panel panel-primary">

    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-6 text-left">
                <h3>{{ trans('app.appointment') }}</h3>
            </div>
            <div class="col-sm-6 text-left">
                <a 
                    href="{{route('book.setting')}}" 
                    class="btn btn-primary"
                >
                    <i class="fa fa-clock-o"></i> Set Time for reminder
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div style="margin-bottom: 30px" class="h4">
            <b>Invite Link: </b> <a href="{{ route('book.token.index', (auth()->user()->company) ? auth()->user()->company->token : auth()->user()->token) }}" id="copy-link">{{ route('book.token.index', (auth()->user()->company) ? auth()->user()->company->token : auth()->user()->token) }}</a> <button onclick="copyLink()" id="copy-btn" style="margin-left: 10px">Copy</button>
        </div>

        <table class="datatable display table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('app.token_no') }}</th>
                    <th>{{ trans('app.department') }}</th>
                    <th>{{ trans('Section') }}</th>
                    <th>{{ trans('app.counter') }}</th>
                    <th>{{ trans('app.officer') }}</th>
                    <th>{{ trans('app.client_mobile') }}</th>
                    <th>Name</th>
                    <th>{{ trans('Note') }}</th>
                    <th>{{ trans('app.status') }}</th>
                    <th>{{ trans('app.created_by') }}</th>
                    <th>{{ trans('app.created_at') }}</th>
                    <th width="120">{{ trans('app.action') }}</th>
                    
                    {{-- @if(issetAccess(auth()->user()->user_role_id)->token['active_token']['write'])
                    <th width="120">{{ trans('app.action') }}</th>
                    @endif --}}
                </tr>
            </thead> 
            <tbody>
                @if (!empty($tokens))
                    <?php $sl = 1 ?>
                    @foreach ($tokens as $token)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>
                                {!! (!empty($token->is_vip)?("<span class=\"label label-danger\" title=\"VIP\">$token->token_no</span>"):$token->token_no) !!} 
                            </td>
                            <td>{{ !empty($token->department)?$token->department->name:null }}</td>
                            <td>
                                {{ \App\Models\Section::find($token->section_id)->name ?? 'none' }}
                            </td>
                            <td>{{ !empty($token->counter)?$token->counter->name:null }}</td>
                            <td>
                                {!! (!empty($token->officer)?("<a href='".url("admin/user/view/{$token->officer->id}")."'>".$token->officer->firstname." ". $token->officer->lastname."</a>"):null) !!}
                            </td>
                            <td>
                                {{ $token->client_mobile }}<br/>
                                {!! (!empty($token->client)?("(<a href='".url("admin/user/view/{$token->client->id}")."'>".$token->client->firstname." ". $token->client->lastname."</a>)"):null) !!}
                            </td>
                            <td>{{ $token->note }}</td>
                            <td>{{ $token->note2 }}</td>
                            <td> 
                                @if($token->status==0) 
                                <span class="label label-primary">{{ trans('app.pending') }}</span> 
                                @elseif($token->status==1)   
                                <span class="label label-success">{{ trans('app.complete') }}</span>
                                @elseif($token->status==2) 
                                <span class="label label-danger">{{ trans('app.stop') }}</span>
                                @endif
                                {!! (!empty($token->is_vip)?('<span class="label label-danger" title="VIP">VIP</span>'):'') !!}
                            </td>
                            <td>{!! (!empty($token->generated_by)?("<a href='".url("admin/user/view/{$token->generated_by->id}")."'>".$token->generated_by->firstname." ". $token->generated_by->lastname."</a>"):null) !!}</td> 
                            <td>{{ (!empty($token->created_at)?date('j M Y h:i a',strtotime($token->created_at)):null) }}</td>
                            
                            {{-- @if(issetAccess(auth()->user()->user_role_id)->token['active_token']['write']) --}}
                            <td>
                                <div class="btn-group"> 
                                    <a href="{{ url("admin/token/complete/$token->id") }}"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')" title="Complete"><i class="fa fa-check"></i></a>
                                    <button type="button" data-toggle="modal" data-target=".transferModal" data-token-id='{{ $token->id }}' class="btn btn-primary btn-sm" title="Transfer"><i class="fa fa-exchange"></i></button> 

                                    <a href="{{ url("admin/token/stoped/$token->id") }}"  class="btn btn-warning btn-sm" onclick="return confirm('Are you sure?')" title="Stoped"><i class="fa fa-stop"></i></a>

                                    <button type="button" href='{{ url("admin/token/print") }}' data-token-id='{{ $token->id }}' class="tokenPrint btn btn-default btn-sm" title="Print" ><i class="fa fa-print"></i></button>

                                    <a href='{{ url("admin/token/delete/$token->id") }}'class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');" title="Delete"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                            {{-- @endif --}}
                        </tr> 
                    @endforeach
                @endif
            </tbody>
        </table>
    </div> 
</div>  

<!-- Transfer Modal -->
<div class="modal fade transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel">
  <div class="modal-dialog" role="document">
    {{ Form::open(['url' => 'admin/token/transfer', 'class'=>'transferFrm']) }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="transferModalLabel">{{ trans('app.transfer_a_token_to_another_counter') }}</h4>
      </div>
      <div class="modal-body"> 
        <div class="alert hide"></div>
        <input type="hidden" name="id">
        <p>
            <label for="department_id" class="control-label">{{ trans('app.department') }} </label><br/>
            {{ Form::select('department_id', $departments, null, ['placeholder' => 'Select Option', 'class'=>'select2', 'id'=>'department_id']) }}<br/>
        </p>

        <p>
            <label for="counter_id" class="control-label">{{ trans('app.counter') }} </label><br/>
            {{ Form::select('counter_id', $counters, null, ['placeholder' => 'Select Option', 'class'=>'select2', 'id'=>'counter_id']) }}
        </p> 

        <p>
            <label for="user_id" class="control-label">{{ trans('app.officer') }} </label><br/>
            {{ Form::select('user_id', $officers, null, ['placeholder' => 'Select Option', 'class'=>'select2', 'id'=>'user_id']) }}
        </p>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="button btn btn-success" type="submit"><span>{{ trans('app.transfer') }}</span></button>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div> 
@endsection

@push("scripts")
<script type="text/javascript">
function copyLink() {
    let val = $("#copy-link").text();
    navigator.clipboard.writeText(val);
    $("#copy-btn").text("Copied");
};
</script>
@endpush
 