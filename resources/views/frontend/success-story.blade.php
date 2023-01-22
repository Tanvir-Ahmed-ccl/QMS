@extends('frontend.layouts.master')


@section('content')
    <div class="container my-5">
        <div class="row my-5 justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-lg-6">
                <h1>Our Clients</h1>
                {{-- <p>Manage, serve and track your customers across multiple locations in one place.</p> --}}
                <p>
                    If your customers queue while waiting to be served, then you are the one we built the GoKiiw Queue Management System for. 
                    Our queue management solutions are perfect for businesses such as: 
                </p>
                <ul>
                    <li>Airports</li>
                    <li>Banks</li>
                    <li>Events</li>
                    <li>Hospitals</li>
                    <li>Hotels</li>
                    <li>Offices</li>
                    <li>Resturants</li>
                    <li>Retailers</li>
                    <li>Ridesharing</li>
                    <li>Schools</li>
                </ul>
                <br>

                <a href="{{ route('signup') }}" class="btn fw-bolder btn-light-dark me-3 p-3">Try For Free</a>
                <a href="{{ route('signup') }}" class="btn fw-bolder btn-light-dark me-3 p-3">Book a demo</a>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 ps-5">
                <img src="{{ asset('frontend/img/product-image.jpeg') }}" alt="" width="400" class="img-fluid">
            
            
                <div class="text-secondary">
                    <p class="my-4  h6"> <i class="bi bi-heart me-3"></i> Increase customer throughput and satisfaction</p>
                    <p class="my-4 h6"> <i class="bi bi-people me-3"></i> Personalize customers’ wait experiences</p>
                    <p class="my-4 h6"> <i class="bi bi-card-list me-3"></i> Get insights into wait times, service times, and customer flow</p>
                    <p class="my-4 h6"> <i class="bi bi-shield-check me-3"></i> Integrate without implementation fees</p>
                </div>
            </div>
            <!-- col-lg-6 -->
        </div>

        <div class="row my-5">
            <div class="col-12 mb-5">
                <h1>Improve the wait <br> experience with Gokiiw</h1>
            </div>

            <div class="col-lg-12 mt-5">
                <div class="row">
                    <div class="col-lg">
                        <p>Decrease wait times up to</p>
                
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>50%</strong></h3>
                        </div>
                    </div>

                    <div class="col-lg">
                        <p>Reduce no-shows up to</p>
                    
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>75%</strong></h3>
                        </div>
                    </div>

                    <div class="col-lg">
                        <p>Increase CSAT up to</p>
                    
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>97%</strong></h3>
                        </div>
                    </div>


                    <div class="col-lg">
                        <p>Quick Setup</p>
                    
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>10 min</strong></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="row d-none my-5 justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">

                <p>Powered by self-service</p>
                <h1>Check-in kiosk</h1>
            
                <br>

                <div class="text-secondary">
                    <p class="my-4  h6"> <i class="bi bi-check-circle me-3"></i> Enable self-check-in for waiting lines via Ipad </p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Capture customer information and data</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Minimize frustration and human error</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Offer a multilingual interface</p>
                </div>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 order-first ps-5">
                <img src="{{ asset('frontend/img/check-in-kiosk.png') }}" alt="" width="400" class="img-fluid">
            </div>
            <!-- col-lg-6 -->
        </div><!--  .row  --> --}}


        <div class="row my-5 justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">

                <p>Intuitive digital signage</p>
                <h1>Waiting room TV</h1>
            
                <br>

                <div class="text-secondary">
                    <p class="my-4  h6"> <i class="bi bi-check-circle me-3"></i> Enable self-check-in for waiting lines via Ipad </p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Capture customer information and data</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Minimize frustration and human error</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Offer a multilingual interface</p>
                </div>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 ps-5">
                <img src="{{ asset('frontend/img/waitlist.jpeg') }}" alt="" width="400" class="img-fluid">
            </div>
            <!-- col-lg-6 -->
        </div><!--  .row  -->



        <div class="row my-5 justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">

                <p>Customer service, done easy</p>
                <h1>Service dashboard</h1>
            
                <br>

                <div class="text-secondary">
                    <p class="my-4  h6"> <i class="bi bi-check-circle me-3"></i>Seamlessly organize the waitlist </p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Move, forward and reassign customers</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Categorize customers and service lines</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Chat with customers via SMS</p>
                </div>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 order-first ps-5">
                <img src="{{ asset('frontend/img/service-screen.jpeg') }}" alt="" width="500" class="img-fluid">
            </div>
            <!-- col-lg-6 -->
        </div><!--  .row  -->


        <div class="row my-5 justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">

                <p>Data in one place, accessible anywhere</p>
                <h1>Service analytics</h1>
            
                <br>

                <div class="text-secondary">
                    <p class="my-4  h6"> <i class="bi bi-check-circle me-3"></i>Measure and monitor KPIs </p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Understand customers’ reason of visit</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Monitor team performance</p>
                    <p class="my-4 h6"> <i class="bi bi-check-circle me-3"></i> Reduce operational costs</p>
                </div>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 ps-5">
                <img src="{{ asset('frontend/img/data-insights.jpeg') }}" alt="" width="600" class="img-fluid">
            </div>
            <!-- col-lg-6 -->
        </div><!--  .row  -->




        {{-- <div class="row px-5 justify-content-center align-items-end">
            
            <div class="col-12 my-5 text-center">
                <h2>Start building stronger customer relationships, today</h2>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="card shadow p-3" style="height: 30vh;">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col">
                                <h5 class="mb-3"><strong>Starter</strong></h5>
                            </div>
                            <div class="col text-end">
                                <h5>$ 429</h5> / month
                            </div>
                        </div>

                        <p>Everything you need to digitize your queue management.</p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow p-3" style="height: 50vh;">
                    <div class="card-body">

                        <div class="text-center">
                            <i class="bi bi-trophy" style="font-size: 50px"></i>
                            <span class="text-primary h5">Recomended</span>
                        </div>

                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h5 class="mb-3"><strong>Business</strong></h5>
                            </div>
                            <div class="col text-end">
                                <h5>$ 629</h5> / month
                            </div>
                        </div>

                        <p>Starter features + SMS notifications & branding options.</p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->


           <div class="col-lg-4 mb-3">
                <div class="card shadow p-3" style="height: 30vh;">
                    <div class="card-body">

                       <h5 class="mb-5"><strong>Enterprise</strong></h5>

                        <p>Ideal for a seamless rollout across multiple service locations.</p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->

    
            
        </div>
        <!---   .row   --> --}}
    </div>


@endsection