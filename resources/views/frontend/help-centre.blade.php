@extends('frontend.layouts.master')


@section('content')
    <div class="container my-5">
        <div class="row my-5 justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-lg-8 text-center">
                <h1>Help Centre</h1>
                
                {{-- <p>Manage, serve and track your customers across multiple locations in one place.</p> --}}
                <p class="my-5">
                    We're here to help you get the most out of GoKiiw. Whether you’re a first-time user or a seasoned pro, our help center has the answers you’re looking for.
                    Browse our help topics to learn how to use the software, view our FAQs, or contact us directly with any questions or feedback.
                </p>
            </div>
            <!-- col-lg-8 -->
        </div>


        <div class="row justify-content-center my-5">
            <div class="col-8">
                <h5>Need help? Don't wait around, send us a message so we can help</h5>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <form action="javascript::" method="post">
                            <div class="form-group mb-4">
                                <label for="email"><b>Email</b></label>
                                <input type="email" 
                                    name="email" 
                                    class="form-control"
                                />

                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for=""><b>Message</b></label>
                                <textarea name="message"
                                    class="form-control" cols="30" rows="5"></textarea>
                            </div>

                            <button class="btn btn-outline-dark">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection