<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Gokiiw</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="card shadow">
                    <div class="card-body">
                        <h4>{{companyDetails($token->company_id)->title}}</h4>
                        <h1 class="my-3">{{$token->token_no}}</h1>

                        <p class="mb-3">{!!$data['serial']!!} <b>person left</b></p> 
                        <h5 class="text-success">Aproximate waiting time: <span class="text-danger">{{$data['apx_time']}}</span> minutes</h5>

                        <p class="m-0"><b>Location:</b> {{$token->department->name ?? ''}}</p>
                        <p class="m-0"><b>Service:</b> {{$token->section->name ?? ''}}</p>
                        <p class="m-0"><b>Counter:</b> {{$token->counter->name ?? ''}}</p>
                        <p class="m-0"><b>Officer:</b> {{$token->officer->firstname . ' ' . $token->officer->lastname}}</p>
                        <p class="m-0"><b>Date:</b> {{date("Y-m-d H:i:s", strtotime($token->created_at))}}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
  </body>
</html>
