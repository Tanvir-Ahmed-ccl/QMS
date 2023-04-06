<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

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
                  
                </div>

                <div class="card-body text-center">
                    <h4>Codecell Limited</h4>
                    <h1 class="my-3">1Q021</h1>

                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <span class="btn btn-sm btn-primary fw-bolder">Service One</span>
                        <i class="bi bi-arrow-right my-auto mx-4" style="font-size: 24px"></i>

                        <span class="btn btn-sm btn-primary fw-bolder">Service Two</span>
                        <i class="bi bi-arrow-right my-auto mx-4" style="font-size: 24px"></i>
                    
                        <span class="btn btn-sm btn-primary fw-bolder">Service Three</span>
                    </div>

                    <p class="m-0">Department Name</p>
                    <p class="m-0">Service Name</p>
                    <p class="m-0">Counter Name</p>
                    <p class="m-0">Office Name</p>
                    <p class="m-0">{{date("d-m-Y")}}</p>
                </div>
              </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>

