<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$setting->title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="col-12 p-0 text-light">
                <h1 class="bg-primary py-3 m-0">{{$setting->title}}</h1>
            </div>
        </div>

        <div class="row bg-dark text-light text-center justify-content-center align-items-center" style="min-height: 70vh">
          <div class="col-12 ">
            
            @if(is_null($setting->announcement))
            <h3>{{$setting->disable_msg}}</h3>
            @else
            <h3>
              {!!$setting->announcement!!}
            </h3>
            @endif
          </div> 
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>
