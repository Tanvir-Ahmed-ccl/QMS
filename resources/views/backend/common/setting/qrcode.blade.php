@extends('layouts.backend')
@section('title', 'QR Code')

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
                        {{-- {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!} --}}
                        <img src="{{ asset(getCompanyDetails(Auth::id())->qrcode) }}" alt="QR Code" width="200">
                        <h5><b>SCAN ME</b></h5>
                        <a href="{{ asset(getCompanyDetails(Auth::id())->qrcode) }}" download="qrcode" class="btn btn-default buttons-download btn-sm" type="button"><span><i class="fa fa-download"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection

 