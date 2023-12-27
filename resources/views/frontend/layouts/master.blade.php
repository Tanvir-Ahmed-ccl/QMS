<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


    <title>Go Kiiw</title>


    <style>
        .btn-primary{
            background-color: indigo;
            border: none;
        }

        .btn-outline-primary{
            /* background-color: indigo; */
            border: 2px solid indigo;
            color: black;
        }

        .btn-outline-primary:hover{
            background-color: indigo;
            border: 2px solid indigo;
        }

        .btn-primary:hover{
            background-color: black;
            border: none;
        }
        .text-primary{
            color: indigo;
        }

        .bg-theme{
            background-color: #f2f7f2;
        }

        .rounded-10{
          border-radius: 10px;
        }

        .btn-light-dark{
          background-color: #1c1c1c;
          color: white;
        }

        .btn-light-dark:hover{
            background-color: #fff;
            border-color: #1c1c1c;
        }

        .card-hover{
          background: none !important;
          cursor: pointer;
        }

        .card-hover:hover{
          background: #D3E4DD !important;
          cursor: pointer;
        }

        
        .navbar .megamenu{ padding: 1rem; }

        /* ============ desktop view ============ */
        @media all and (min-width: 992px) {

          .navbar .has-megamenu{position:static!important;}
          .navbar .megamenu{left:0; right:0; width:100%; margin-top:0;  }

        }	
        /* ============ desktop view .end// ============ */

        /* ============ mobile view ============ */
        @media(max-width: 991px){
          .navbar.fixed-top .navbar-collapse, .navbar.sticky-top .navbar-collapse{
            overflow-y: auto;
              max-height: 90vh;
              margin-top:10px;
          }
        }
        /* ============ mobile view .end// ============ */
    </style>


    @stack('css')
</head>

<body>
    <!-- Nav -->
    {{-- <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
        <div class="container py-3">
            <!-- <a class="navbar-brand" href="#">Sticky top</a> -->


            <a class="navbar-brand" href="#"><h4><strong>Go Kiiw</strong></h4>   </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-5" id="navbarTogglerDemo02">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bolder active" aria-current="page" href="#">Product</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bolder" href="#">Pricing</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bolder" href="#">Learn</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bolder" href="#">Company</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <button class="btn btn-primary">Try for free</button>
                    </li>
                    <li class="nav-item me-3">
                        <button class="btn btn-primary">Login</button>
                    </li>
                </ul>


                <!-- <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav> --}}
    <!-- //.Nav -->


    <!--  Mega Manu  -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">
          <h4><strong>Go Kiiw</strong></h4>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-5" id="main_nav">
          <ul class="navbar-nav">
            <li class="nav-item fw-bolder me-3 active"> <a class="nav-link" href="{{ url('/') }}">Home </a> </li>
            <li class="nav-item me-3 dropdown has-megamenu">
              <a class="nav-link fw-bolder dropdown-toggle" href="javascript::" data-bs-toggle="dropdown"> Products  </a>
              <div class="dropdown-menu megamenu" role="menu">
                
                <div class="container">
                  <div class="row">
                    <div class="col-md-4" style="background-color: #e6ecea">
                      <a href="{{ url('products') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                              <i class="bi bi-people h3"></i>
                              <div>
                                <h6><strong>Gokiiw Queue Management system</strong></h6>
                                {{-- <p>Track, serve, and manage your customer queues across multiple locations</p> --}}
                                <p>
                                  Track, serve, and manage your customer queues across multiple locations.
                                </p>
                              </div>
                            </div>
                        </div><!--  .card  -->
                      </a>

                      <div class="card card-hover border-0 mb-3">
                         <div class="card-body">
                          <i class="bi bi-robot h3"></i>
                          <div>
                            <h6><strong>Service Intelligence</strong></h6>
                            <p>Track server data and measure staff performance.</p>
                          </div>
                        </div>
                      </div><!--  .card  -->
                    </div><!--  .col-md-4  -->

                    <div class="col-md-4">

                      <a href="{{ route('success.story') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body d-inline">
                            <i class="bi bi-trophy h3"></i>
                            <div>
                              <h6><strong>Our Clients</strong></h6>
                              <p>See how other businesses in your industry are using Gokiiw</p>
                            </div>
                          </div>
                        </div><!--  .card  -->
                      </a>

                      <div class="card card-hover border-0 mb-3">
                        <div class="card-body">
                          <i class="bi bi-command h3"></i>
                          <div>
                            <h6><strong>API</strong></h6>
                            <p> Use it to integrate with other apps such as CRMs, support software, backend systems, or patient management apps. </p>
                          </div>
                        </div>
                      </div><!--  .card  -->
                    </div><!--  .col-md-4  -->

                    <div class="col-md-4">
                      
                      <div class="card card-hover border-0 mb-3">
                        <div class="card-body">
                          <i class="bi bi-card-list h3"></i>
                          <div>
                            <h6><strong>List of features</strong></h6>
                            <p>Learn about features and pricing option.</p>
                          </div>
                        </div>
                      </div><!--  .card  -->

                    </div><!--  .col-md-4  -->
                  </div>
                </div><!-- .container  -->

              </div> <!-- dropdown-mega-menu.// -->
            </li>

            <li class="nav-item me-3 dropdown has-megamenu">
              <a class="nav-link fw-bolder dropdown-toggle" href="javascript::" data-bs-toggle="dropdown"> Learn  </a>
              <div class="dropdown-menu megamenu" role="menu">
                
                <div class="container">
                  <div class="row">
                    <div class="col-md-4">
                      <a href="{{ route('help.centre') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                              <i class="bi bi-question-circle h3"></i>
                              <div>
                                <h6><strong>Help Center</strong></h6>
                                <p>Manage, serve and track your customer accross multiple location</p>
                              </div>
                            </div>
                        </div><!--  .card  -->
                      </a>

                      <a href="{{ route('faq') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                            <i class="bi bi-robot h3"></i>
                            <div>
                              <h6><strong>FAQ</strong></h6>
                              <p>Need help? Don't wait around, see frequently ask question.</p>
                            </div>
                          </div>
                        </div><!--  .card  -->
                      </a>
                      
                    </div><!--  .col-md-4  -->

                    <div class="col-md-4">

                      <a href="{{ url('blog') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body d-inline">
                            <i class="bi bi-postcard h3"></i>
                            <div>
                              <h6><strong>Blog</strong></h6>
                              {{-- <p>See how other businesses in your industry are using gokiiw.</p> --}}
                            
                              <p>
                                Our exciting weekly blog posts are where you read all about how our innovative software helps you to:
                                manage queues with ease 
                                save time and money 
                                make the most of our features
                                use our software in different contexts 
                                Sign up here to be the first to read our informative blogs, service updates, and new product releases.

                              </p>
                            </div>
                          </div>
                        </div><!--  .card  -->
                      </a>

                    </div><!--  .col-md-4  -->

                    <div class="col-md-4">

                      <a href="{{ route('podecast') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                            <i class="bi bi-robot h3"></i>
                            <div>
                              <h6><strong>Service Intelligence Podcast</strong></h6>
                              <p>Track server data and measure staff performance.</p>
                            </div>
                          </div>
                        </div><!--  .card  -->
                      </a>

                    </div><!--  .col-md-4  -->
                  </div>
                </div><!-- .container  -->

              </div> <!-- dropdown-mega-menu.// -->
            </li>

            <li class="nav-item me-3 fw-bolder "><a class="nav-link" href="{{ url('/pricing') }}"> Pricing </a></li>
            
            <li class="nav-item me-3 dropdown has-megamenu">
              <a class="nav-link fw-bolder dropdown-toggle" href="javascript::" data-bs-toggle="dropdown"> Company  </a>
              <div class="dropdown-menu megamenu" role="menu">
                
                <div class="container">
                  <div class="row">
                    <div class="col-md-4">
                      <a href="{{ url('about-us') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                              <i class="bi bi-exclamation-circle h3"></i>
                              <div>
                                <h6><strong>About Us</strong></h6>
                                <p>Manage, serve and track your customer accross multiple location</p>
                              </div>
                            </div>
                        </div><!--  .card  -->
                      </a>

                      
                    </div><!--  .col-md-4  -->

                    <div class="col-md-4">

                      <a href="{{ route('careers') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                            <i class="bi bi-briefcase h3"></i>
                            <div>
                              <h6><strong>Careers</strong></h6>
                              <p> Interested in joining the quest for a better customer service experience? Learn more about working at gokiiw. <p>
                            </div>
                          </div>
                        </div><!--  .card  -->
                      </a>

                    </div><!--  .col-md-4  -->

                    <div class="col-md-4">
                      
                      <a href="{{ route('help.centre') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover border-0 mb-3">
                          <div class="card-body">
                            <i class="bi bi-chat h3"></i>
                            <div>
                              <h6><strong>Contact Us</strong></h6>
                              <p>Learn about features and pricing option.</p>
                            </div>
                          </div>
                        </div><!--  .card  -->
                      </a>

                    </div><!--  .col-md-4  -->
                  </div>
                </div><!-- .container  -->

              </div> <!-- dropdown-mega-menu.// -->
            </li>
            
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="btn btn-light-dark fw-bolder rounded-10 me-3" href="{{ route('signup') }}"> Try for free </a></li>
            <li class="nav-item"><a class="btn btn-light-dark fw-bolder rounded-10" href="{{ route('login') }}"> Login </a></li>
            
          </ul>
        </div> <!-- navbar-collapse.// -->
      </div> <!-- container-fluid.// -->
    </nav>

    
    @yield('content')

    <footer class="mt-5 bg-dark text-light">
        <div class="container pt-5">
            <div class="row  justify-content-center">
                <div class="col-lg-2">
                    <h4><strong>Go Kiiw</strong></h4>
                </div>
                <div class="col-lg-2">
                    <strong>Products</strong>
                    <br><br>
                    <ul class="list-unstyled">
                        <li class="mb-2">Queue Solution</li>
                        <li class="mb-2">Service Analytics</li>
                        <li class="mb-2">Visit Planner</li>
                        <li class="mb-2">Pricing</li>
                        <li class="mb-2">Sign Up</li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <strong>Solutions</strong>
                    <br><br>
                    <ul class="list-unstyled">
                        <li class="mb-2">Finance</li>
                        <li class="mb-2">Healthcare</li>
                        <li class="mb-2">Click & Collect</li>
                        <li class="mb-2">Education</li>
                        <li class="mb-2">Government</li>
                        <li class="mb-2">Ridesharing</li>
                        <li class="mb-2">Dispensaries</li>
                    </ul>
                </div>
                <!-- col-lg-2 -->
                <div class="col-lg-2">
                    <strong>Resources</strong>
                    <br><br>
                    <ul class="list-unstyled">
                        <li class="mb-2">Support</li>
                        <li class="mb-2">Api Documentation</li>
                        <li class="mb-2">Customers</li>
                        <li class="mb-2">Case Studies</li>
                        <li class="mb-2">Blog</li>
                    </ul>
                </div>
                <!-- col-lg-2 -->
                <div class="col-lg-2">
                    <strong>Company</strong>
                    <br><br>
                    <ul class="list-unstyled">
                        <li class="mb-2">About Us</li>
                        <li class="mb-2">Careers</li>
                        <li class="mb-2">Contact</li>
                        <li class="mb-2">Terms of services</li>
                        <li class="mb-2">Status</li>
                    </ul>
                </div>
                <!-- col-lg-2 -->

                <div class="col-12 my-4">
                    <div class="row">
                      <div class="col">
                          <p class="m-0">Gokiiw &#169; {{date("Y")}}. All Rights Reserved.</p>
                      </div>
                      <div class="col text-end">
                        <p class="m-0">Owned By <a href="https://softafrique.net/" class="text-decoration-none" target="_blank">Softafrique LLC</a></p>
                      </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        </div>
        <!-- container -->
    </footer>


    <!-- Bootstrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    >
    </script>
</body>

</html>