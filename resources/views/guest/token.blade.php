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

                <div class="card">
                    <div class="card-body">
                        <h3>{{companyDetails($token->company_id)->title}}</h3>
                        <h1>{{$token->token_no}}</h1>

                        <h5>Location: {{$token->department->name ?? ''}}</h5>
                        <h5>Counter: {{$token->counter->name ?? ''}}</h5>
                        <h5>Officer: {{$token->officer->firstname ?? '' . ' ', $token->officer->firstname ?? ''}}</h5>
                        <h5>Name: {{$token->note ?? ''}}</h5>
                        <h5>Date: {{date("Y-m-d H:i:s", strtotime($token->created_at))}}</h5>
                    </div>
                </div>

            </div>
        </div>
    </div>
  </body>
</html>
