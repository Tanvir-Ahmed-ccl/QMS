@extends('frontend.layouts.master')


@section('content')
    <div class="container mb-5">
        <div class="row my-5 justify-content-between align-items-center" style="min-height: 80vh;">
            <div class="col-lg-3">
                <h1><span class="text-success">Simple</span> Pricing</h1>
                <p>Unlimited locations, easy roll-out</p>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-8">
                {{-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Monthly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Annual</button>
                    </li>
                </ul> --}}
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="row align-items-end">

                            @foreach (\App\Models\Plan::where('status', true)->get() as $item)
                            <div class="col-lg p-0 mb-4">
                                <div class="card bg-none">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h5 class="fw-bolder">{{ $item->title }}</h5>
                                            <h2 class="fw-bolder">{{\App\Models\AppSettings::first()->CURRENCY_SIGN}} {{ $item->price_per_month }} <small>/mo</small></h2>
                                        </div>
                                        <div class="my-4">
                                           {!! $item->details !!}
                                        </div>
                                        
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" class="btn btn-outline-dark mt-3">Try It</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{-- <div class="col-lg p-0">
                                <div class="card px-2" style="background-color: #D3E4DD">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h3 class="fw-bolder">Business</h3>
                                            <h1 class="fw-bolder">$ 629</h1> /month
                                        </div>
                                        <div class="my-4">
                                           Includes Starter features <br>
                                            + SMS notifications *   <br>
                                            + custom check-in and TV designs
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-outline-dark mt-3">Try for free</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg p-0">
                                <div class="card bg-none">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h5 class="fw-bolder">Enterprise</h5>
                                            <h2 class="fw-bolder">Custom Pricing</h2>
                                        </div>
                                        <div class="my-4">
                                           A quick, seamless rollout to support all your team members
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-outline-dark mt-3">Try for free</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="row align-items-center">

                            <div class="col-lg p-0">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="mb-3 text-center">
                                            <h5 class="fw-bolder">Basic</h5>
                                            <h1 class="fw-bolder text-primary">$50</h1>
                                        </div>
                                        <div>
                                            <ul class="list-unstyled">
                                                <li><i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li><i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li> <i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li> <i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                            </ul>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary mt-3">Order Plan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg p-0">
                                <div class="card py-3 shadow border-0">
                                    <div class="card-body">
                                        <div class="mb-3 text-center">
                                            <h5 class="fw-bolder">Standard</h5>
                                            <h1 class="fw-bolder text-primary">$150</h1>
                                        </div>
                                        <div>
                                            <ul class="list-unstyled">
                                                <li><i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li><i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li> <i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li> <i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                            </ul>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary mt-3">Order Plan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg p-0">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="mb-3 text-center">
                                            <h5 class="fw-bolder">Premium</h5>
                                            <h1 class="fw-bolder text-primary">$250</h1>
                                        </div>
                                        <div>
                                            <ul class="list-unstyled">
                                                <li><i class="bi bi-check-circle-fill me-2 text-primary"></i> Eu commodo.</li>
                                                <li><i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li> <i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                                <li> <i class="bi bi-check-circle-fill me-2 text-primary"></i> Vel orci aliquam.</li>
                                            </ul>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary mt-3">Order Plan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- col-lg-6 -->
        </div>




        <div class="row my-5 justify-content-between align-items-center" style="min-height: 80vh;">
            <div class="col-lg-4">
                <h1 class="fw-bolder">Frequently asked <span class="text-success">questions</span></h1>
            </div>
            <!-- col-lg-6 -->


            <div class="col-lg-8">
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <div class="accordion-header " id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <h5><strong>Can we use for social distancing?</strong></h5>
                            </button>
                        </div>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-4">
                                Yes. Gokiiw is geared for safe queuing practices, such as remote sign-in via QR code, online check-in, SMS two-way communication, and a virtual waitlist. Read more about our safety guidelines and tips.
                            </div>
                        </div>
                    </div>
                    <!--    .accordion-item   -->

                    <div class="accordion-item">
                        <div class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5><strong>Can we trial before paying?</strong></h5>
                            </button>
                        </div>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body p-4">
                            We offer a 14-day free trial that lets you test out all the features. The trial can be extended if needed. Please contact our team if you want to extend your trial.
                        </div>
                        </div>
                    </div>
                    <!--    .accordion-item   -->

                    <div class="accordion-item">
                        <div class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                <h5><strong>Which plan should I choose ?</strong></h5>
                            </button>
                        </div>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                        <div class="accordion-body p-4">
                           The most suitable plan for you depends on your use case. If in doubt, please contact us at sales@gokiiw.com. Our customer success team can help you evaluate which features would benefit your use case the most.
                        </div>
                        </div>
                    </div>
                    <!--    .accordion-item   -->


                    <div class="accordion-item">
                        <div class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                <h5><strong>Does it need apple device ?</strong></h5>
                            </button>
                        </div>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-4">
                            Yes. We want to offer both you and your customers a premium experience without any hassle. Using Apple devices pretty much guarantees it.
                            </div>
                        </div>
                    </div>
                    <!--    .accordion-item   -->


                    <div class="accordion-item">
                        <div class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                <h5><strong>Is hardware/equipment included ?</strong></h5>
                            </button>
                        </div>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-4">
                                The hardware expenses depend on your preferred level of involvement.

                                To use Gokiiw at its most basic, you only need a web browser, on either your computer or smart device. If you want to use a self-service solution, you need an iPad and a stand. If you want a visitor guidance solution, you need an Apple TV.

                                To purchase the required hardware, please contact your local Apple reseller.
                            </div>
                        </div>
                    </div>
                    <!--    .accordion-item   -->


                </div>


                <div class="mt-5">
                    <h4>Have any <span class="text-success">more questions?</span></h4>
                    <h6>Drop us a line at sales@gokiiw.com <br>  or use a live chat.</h6>
                </div>
            </div>
            <!-- col-lg-6 -->
        </div>
    </div>


@endsection