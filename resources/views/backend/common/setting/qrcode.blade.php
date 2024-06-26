@extends('layouts.backend')
@section('title', 'Remote Queue')

@section('content')

<div class="panel panel-primary">
    {{-- <div class="panel-heading pt-0 pb-0">
        <ul class="list-inline">       
            <li>
                <button id="toggleScreen" class="btn btn-sm btn-primary"><i class="fa fa-arrows-alt"></i></button>
            </li> 
            <li>
                
            </li> 
        </ul>
    </div> --}}
    <div class="panel-body"> 
        <div class="row">
            <div class="col-sm-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        {!! QrCode::size(250)->generate(route('guestLogin', companyOwner(Auth::id())->token)); !!}
                        
                        <h5><b>SCAN ME</b></h5>

                        <a 
                            target="_blank"
                            title="Copy Link"
                            href="{{route('guestLogin', companyOwner(Auth::id())->token)}}"
                        >{{route('guestLogin', companyOwner(Auth::id())->token)}} </a>
                        <button onclick="copyQrCode()" class="mb-3" id="copy-qr-btn">Copy</button>
                        
                        <br>
                        <a href="{{ asset(getCompanyDetails(Auth::id())->qrcode) }}" download="qrcode" class="btn btn-default buttons-download btn-sm" type="button" style="margin-top: 10px"><span><i class="fa fa-download"></i></span></a>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection

@push("scripts")
<script type="text/javascript">
function copyQrCode() {
    // let val = "{{route('guestLogin', getCompanyDetails(Auth::id())->token)}}";
    // navigator.clipboard.writeText('');
    navigator.clipboard.writeText("{{route('guestLogin', getCompanyDetails(Auth::id())->token)}}");
    $("#copy-qr-btn").text('Copied')
};
</script>
@endpush
 
 