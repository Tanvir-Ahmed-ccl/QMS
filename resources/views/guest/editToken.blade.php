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
        <div class="row justify-content-center">
            <div class="col-lg-6 mt-5">

                <div class="card shadow">
                    <div class="card-header bg-primary text-center text-light">
                      <h4 class="card-title">{{companyDetails($data['token']->company_id)->title}}</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{route('guest.token.update')}}" method="POST">
                          @csrf
                          <input type="hidden" name="tokenId" value="{{$data['token']->id}}">

                          <div class="form-group">
                            <label for="key">Select a {{trans('app.service')}} <i class="text-danger">*</i></label><br/>
                            <select name="section_id" class="form-control">
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
                            <input type="time" class="form-control" name="time" value="{{date("H:i", strtotime($data['token']?->created_at))}}">
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
  </body>
</html>
