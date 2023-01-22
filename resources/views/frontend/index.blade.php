@extends('frontend.layouts.master')


@section('content')

    {{-- <div class="container my-5 pt-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">
                <h1>Know Who You Are Serving?</h1>
                <p>Learn more about your customers and their needs through queue management and service analytics.</p>
            
                <br>

                <a href="{{ route('signup') }}" class="btn btn-outline-primary me-3 p-3">Try For Free</a>
                <a href="{{ route('signup') }}" class="btn btn-outline-primary me-3 p-3">Book a demo</a>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 text-center">
                <img src="{{ asset('frontend/img/boy-red.png') }}" alt="" class="img-fluid">
            </div>
            <!-- col-lg-6 -->
        </div>
    </div> --}}

    <div class="container my-5 pt-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">
                <h1>Next customer, please!</h1>
                <p style="color: #000">
                    Welcome to GoKiiw, the queue management system that helps your customers queue quickly and easily.
                    No more waiting in line. With GoKiiw, you can create and manage a queue virtually for any event, shop, or service.
                    Our queue management system simplifies the process of forming queues, saving your customers time and hassle.
                    Learn more about your customers and their needs through our queue management and service analytics.
                </p>
            
                <br>

                <a href="{{ route('signup') }}" class="btn btn-outline-primary me-3 p-3">Try For Free</a>
                <a href="{{ route('signup') }}" class="btn btn-outline-primary me-3 p-3">Book a demo</a>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-6 text-center">
                <img src="{{ asset('frontend/img/boy-red.png') }}" alt="" class="img-fluid">
            </div>
            <!-- col-lg-6 -->
        </div>
    </div>



    <div class="container bg-dark">
        <div class="row justify-content-center align-items-center p-5">
            <div class="col-lg-12 text-center">
                <!-- <img src="img.png" alt="" class="img-fluid"> -->
                <img src="{{ asset('frontend/img/dashboard.png') }}" alt="" class="img-fluid">
            </div>

            <!-- <div class="col-lg-12 text-center text-white mt-5">
                <h3>Trusted by the industry leaders</h3>
            </div> -->
        </div>
    </div>



    <div class="container my-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-10 text-center">
                <h1>Gokiiw helps businesses save their customers 1,000+ hours of waiting in line, every day.</h1>
                <p class="my-3">
                    Long queues cost businesses across the world trillions of dollars in lost sales. Customers who experience poor queuing
                    are less likely to stay and recommend your business.
                </p>
            </div>

            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4">
                        <p>Decrease wait times up to</p>
                
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>50%</strong></h3>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <p>Reduce no-shows up to</p>
                    
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>75%</strong></h3>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <p>Increase CSAT up to</p>
                    
                        <div style="border-left: 5px solid gray; padding-left: 10px">
                            <h3><strong>97%</strong></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container bg-theme">
        <div class="row px-5 justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col px-5">
                <h1>Get Started with Gokiiw</h1>
                <p>It only takes a few minutes to get started with Gokiiw. Learn more about your customers, start free, today.</p>
            
                <div class="my-3">
                    <a href="{{ route('signup') }}" class="btn btn-outline-primary p-3 me-3">Book a demo</a>
                    <a href="{{ route('signup') }}" class="btn btn-outline-primary p-3">Try for free</a>
                </div>
            </div>

            <div class="col-lg-4 text-secondary">
                <p class="my-4  h6"> <i class="bi bi-credit-card me-3"></i> No installation fees</p>
                <p class="my-4 h6"> <i class="bi bi-heart me-3"></i> 80+ million visitors served</p>
                <p class="my-4 h6"> <i class="bi bi-bookmark-check me-3"></i> GDPR-, SOC 2 Type II & HIPAA-ready</p>
            </div>
        </div>
    </div>



    <div class="container mb-5">
        <div class="row px-5 justify-content-center align-items-center">
            
            <div class="col-12 my-5 text-center">
                <h1>Great customer service, powered by data</h1>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="card shadow px-3" style="height: 50vh;">
                    <div class="card-body">
                        <i class="bi bi-bar-chart mb-3" style="font-size: 50px;"></i>

                        <h5 class="mb-3"><strong>See your business from a bird’s eye view</strong></h5>

                        <p>Compare the performance of different locations and departments. Monitor the number of visitors waiting, average wait
                            times, and other metrics.
                        </p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow px-3" style="height: 50vh;">
                    <div class="card-body">
                        <i class="bi bi-people mb-3" style="font-size: 50px;"></i>
            
                        <h5 class="mb-3"><strong>Empower your team with real-time metrics</strong></h5>
            
                        <p>
                            Give your staff the tools they need to supercharge your customer service. Recognize your team’s achievements and
                            identify opportunities for growth.
                        </p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->


            <div class="col-lg-4 mb-3">
                <div class="card shadow px-3" style="height: 50vh;">
                    <div class="card-body">
                        <i class="bi bi-trophy mb-3" style="font-size: 50px;"></i>
            
                        <h5 class="mb-3"><strong>Gain insights into how your business works</strong></h5>
            
                        <p>
                            Easily measure and share performance results. Use service reports to keep track of KPIs and the effectiveness of service
                            strategy.
                        </p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->
    
            
        </div>


        <div class="row px-5 mt-5 justify-content-center align-items-center">
        
            <div class="col-12 my-5 text-center">
                <h1>Virtual waiting, real experiences</h1>
            </div>
        
            <div class="col-lg-4 mb-3">
                <div class="card shadow px-3" style="height: 50vh;">
                    <div class="card-body">
                        <i class="bi bi-check-circle mb-3" style="font-size: 50px;"></i>
        
                        <h5 class="mb-3"><strong>Let customers join remotely</strong></h5>
        
                        <p>
                            Eliminate in-person lines by allowing customers to join a virtual waitlist using their phones. Monitor your line in
                            real-time.
                        </p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->
        
            <div class="col-lg-4 mb-3">
                <div class="card shadow px-3" style="height: 50vh;">
                    <div class="card-body">
                        <i class="bi bi-geo-alt mb-3" style="font-size: 50px;"></i>
        
                        <h5 class="mb-3"><strong>Wait from anywhere</strong></h5>
        
                        <p>
                            Let customers safely wait in their car, at home, or outside. Notify them when you are ready to serve them.
                        </p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->
        
        
            <div class="col-lg-4 mb-3">
                <div class="card shadow px-3" style="height: 50vh;">
                    <div class="card-body">
                        <i class="bi bi-wechat mb-3" style="font-size: 50px;"></i>
        
                        <h5 class="mb-3"><strong>Keep an open line of communication</strong></h5>
        
                        <p>
                            Give customers regular updates and wait times. Make them feel like VIPs by talking to them directly and asking for their
                            feedback.
                        </p>
                    </div>
                </div>
            </div>
            <!-- col-lg-4 -->
        
        
        </div>
    </div>


@endsection