@extends('frontend.layouts.master')


@section('content')
    <div class="container mb-5 px-5">


        <div class="row align-items-center" style="min-height: 50vh">
            <div class="col text-center">
                <h1 class="text-secondary fw-bolder">About Us</h1>
            </div>
        </div>
            

        {{-- <div class="row align-items-center min-vh-100 justify-content-between">
            <div class="col-lg-6">
                <h1 class="mb-4">Then</h1>

                <h5>Gokiiw started in 2011, as part of the Estonia-based Garage48 startup hackathon. A small team of developers asked themselves two questions:
                    <br><br>  Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione praesentium exercitationem neque blanditiis, libero nisi perferendis atque placeat natus quam?
                </h5>
            </div>

            <div class="col-lg-6">
                <img src="{{ asset('frontend/1.webp') }}" alt="" width="500" class="img-fluid">
            </div>

        </div>
            

        <div class="row min-vh-100 align-items-center justify-content-between">
            <div class="col-lg-6">
                <h1 class="mb-4">Then</h1>

                <h5>
                    Now, Gokiiw is a B2B SaaS company with an international presence. Over the years, some of the world’s most influential companies — Uber, AT&T, Verizon — have recruited Gokiiw to solve their customer experience problems.
                </h5>
            </div>

            <div class="col-lg-6 order-first">
                <img src="{{ asset('frontend/2.webp') }}" alt="" width="400" class="img-fluid">
            </div>
        
        </div> --}}

        {{-- <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col">
                {!! \App\Models\AppSettings::first()->ABOUT_US_ONE !!}
            </div>
        </div> --}}

        <div class="row align-items-center justify-content-center">
            <div class="col text-center">
                <h5>Welcome to GoKiiw! </h5>

                We are the premier global provider of queue management solutions. 
                Our software helps businesses streamline their customer experience by providing a fast, secure, and efficient way to manage queues on site or virtually.
                We understand that the customer experience is key to success and our software helps make sure that your customers don't have to stand in long lines or wait around for service. We make sure that customers can quickly get in line in the correct order and be served in a timely manner.
                Our software also allows you to monitor the performance of your service and make informed decisions about how to improve it. With our powerful analytics tools, you can view and analyze real-time data on customer wait times, service response times, and customer satisfaction ratings. Our software therefore provides you with valuable insights about the efficiency of your services.
                We believe that forming queues should be easy, so we designed GoKiiw to make the process as simple and straightforward as possible. Try it out today and see for yourself.
                <br>
                <br>
                <a href="{{ route('signup') }}" class="btn btn-outline-primary me-3 p-3">Try For Free</a>
                <a href="{{ route('signup') }}" class="btn btn-outline-primary me-3 p-3">Book a demo</a>

            </div>
        </div>



        <div class="row gx-2 my-5 py-5 align-items-center justify-content-center">
            <div class="col-md text-center">
                <h1 class="mb-3 fw-bolder text-success">2011</h1>
                <h5>Gokiiw launched</h5>
            </div>

           <div class="col-md text-center">
                <h1 class="mb-3 fw-bolder text-success">40+</h1>
                <h5>Countries</h5>
            </div>

            <div class="col-md text-center">
                <h1 class="mb-3 fw-bolder text-success">70M+</h1>
                <h5>Visitors served</h5>
            </div>
        
        </div>

    </div>


@endsection