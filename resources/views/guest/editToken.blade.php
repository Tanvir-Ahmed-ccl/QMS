<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <title>{{env("APP_NAME")}}</title>
  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
              <div class="card shadow">
                <div class="card-header p-4 bg-primary text-center text-light">
                  <h2 class="card-title fw-bolder">{{companyDetails($data['token']->company_id)->title}}</h2>
                </div>
                <div class="card-body">

                  <div class="row justify-content-center">
                    <div class="col-5 border p-3">
                      <form action="{{route('guest.token.update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="tokenId" value="{{$data['token']->id}}">

                        <div class="form-group mb-3">
                          <label for="key">Select a {{trans('app.service')}} <i class="text-danger">*</i></label><br/>
                          <select name="section_id[]" class="form-control js-example" multiple>
                            @foreach ($data['sections'] as $section)
                                <option value="{{$section->id}}" {{ ($section->id == $data['token']->section_id) ? "selected" : '' }} >{{$section->name}}</option>
                            @endforeach
                          </select>
                          @error('section_id')
                            <strong class="text-danger">{{$message}}</strong>
                          @enderror
                        </div>

                        <div class="mb-3">
                          <label for="">Time</label>
                          <input type="time" class="form-control" name="time" value="{{date("H:i", strtotime($data['token']->created_at))}}">
                        </div>

                        <div class="mb-3">
                          <label for="">Name</label>
                          <input type="text" class="form-control" name="note" value="{{$data['token']->note}}" readonly>
                        </div>

                        <div class="mb-3">
                          <label for="">Note</label>
                          <input type="text" class="form-control" name="note2" value="{{$data['token']->note2}}">
                        </div>

                        <button class="btn btn-outline-primary">Save</button>
                      </form>
                      
                      </div>
                    </div>
                  </div>

              </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
      $(document).ready(function() {
          $(".js-example").select2();
      });
    </script>



  </body>
</html>
