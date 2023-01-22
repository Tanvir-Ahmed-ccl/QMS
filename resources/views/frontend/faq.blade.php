@extends('frontend.layouts.master')


@section('content')
    <div class="container my-5">
        <div class="row my-5 justify-content-center align-items-center" style="min-height: 50vh;">
            <div class="col-lg-8 text-center">
                <h1>FAQ</h1>
                
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
                <h5 class="mb-3">How do I know if my business needs the GoKiiw Queue Management System?</h5> 
                
                <table class="table table-bordered table-hover table-striped w-100">
                    <tr>
                        <th>Without Queue Management</th>
                        <th>With GoKiiw Queue Management Solutions</th>
                    </tr>

                    <tr>
                        <td>Long wait times</td>
                        <td>Decreased customer wait times </td>
                    </tr>

                    <tr>
                        <td>Customer frustration and dissatisfaction</td>
                        <td>Enhanced customer satisfaction </td>
                    </tr>
                    <tr>
                        <td>Reduced customer service</td>
                        <td>  Improved customer service </td>
                    </tr>

                    <tr>
                        <td>Staff overwhelm </td>
                        <td>Staff efficiency </td>
                    </tr>
                    <tr>
                        <td>Loss of potential customers</td>
                        <td>Increased potential customer base </td>
                    </tr>
                    <tr>
                        <td>Loss of potential revenue</td>
                        <td>Increased revenue and profits </td>
                    </tr>
                    <tr>
                        <td>Loss of reputation and negative reviews</td>
                        <td>Positive reputation and customer reviews </td>
                    </tr>
                    <tr>
                        <td>Damage to the business’s brand</td>
                        <td>Reinforcement of the business’s brand</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection