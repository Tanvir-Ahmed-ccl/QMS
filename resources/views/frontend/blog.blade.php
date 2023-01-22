@extends('frontend.layouts.master')


@section('content')
    <div class="container mb-5">
        <div class="row my-5 justify-content-center align-items-center" style="min-height: 80vh;">
            
            <div class="row justify-content-center align-items-center" style="min-height: 40vh">
                <div class="col-10 text-center">
                    <h1 class="text-secondary">Success Stories</h1>
                </div>
                <div class="col-10">
                    Our exciting weekly blog posts are where you read all about how our innovative software helps you to:
                    manage queues with ease 
                    save time and money 
                    make the most of our features
                    use our software in different contexts 
                    <br>
                    <a href="{{ route('signup') }}">Sign up here</a> to be the first to read our informative blogs, service updates, and new product releases.
                </div>
            </div>

            
            
            {{-- @for ($i=0; $i<=10; $i++)
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="https://www.qminder.com/resources/img/blog/plate-by-plate/plate-by-plate-staff.png" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Blog title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-dark">See More <i class="bi bi-arrow-right"></i> </a>
                    </div>
                </div>
            </div>
            <!-- col-lg-6 -->
            @endfor --}}

           

            


            
        </div>

    </div>


@endsection