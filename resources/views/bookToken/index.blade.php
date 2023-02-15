<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Gokiiw</title>

    <link rel="stylesheet" href="{{ asset('intelInput/style.css') }}">
    <style>
        .iti{
            display: block !important;
        }
    </style>
  </head>
  <body>
    <div class="container py-5 my-3">
        <div class="row align-items-center">
            <div class="col-12">
              <div class="card shadow">
                <div class="card-header text-center bg-primary text-light">
                  @if (!isset($token))
                      <h2>{{$setting->title ?? ''}}</h2>
                  @endif
                </div>

                @if(isset($token))
                <div class="card-body text-center">
                    <h4>{{companyDetails($token->company_id)->title}}</h4>
                    <h1 class="my-3">{{$token->token_no}}</h1>
                    <p class="m-0"><b>{{ trans('app.location') }}:</b> {{$token->department->name ?? ''}}</p>
                    <p class="m-0"><b>{{ trans('app.service') }}:</b> {{$token->section->name ?? ''}}</p>
                    <p class="m-0"><b>{{ trans('app.counter') }}:</b> {{$token->counter->name ?? ''}}</p>
                    <p class="m-0"><b>{{ trans('app.officer') }}:</b> {{$token->officer->firstname . ' ' . $token->officer->lastname}}</p>
                    <p class="m-0"><b>Date:</b> {{date("Y-m-d H:i:s", strtotime($token->created_at))}}</p>
                </div>
                @else

                <div class="card-body" style="min-height: 60vh">
                  <div class="row my-3">
                    @foreach ($data as $key => $item)
                      <div class="col-md">
                          <form action="{{route('book.token.auth')}}" method="POST">
                            @csrf
                            <input type="hidden" name="department_id" value="{{$item['location']['department_id']}}">
                            <input type="hidden" name="counter_id" value="{{$item['location']['counter_id']}}">
                            <input type="hidden" name="user_id" value="{{$item['location']['user_id']}}">
                            <input type="hidden" name="companyId" value="{{ $setting->company_id }}">
                            
                            <button type="submit" class="btn py-3 px-5 w-100" style="background-color:rgb(79, 79, 211); color:white">
                              <b>{{$item['location']['name']}}</b>
                            </button>

                          </form>
                      </div>
                    @endforeach
                  </div>
                </div>
                @endif
              </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
