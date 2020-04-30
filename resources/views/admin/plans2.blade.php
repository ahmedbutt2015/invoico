@extends('dashboard',['a' => 'Profile'])
@section('body')
    <style>
        .li-plan{

            line-height: 2;
            border-bottom: 1px #f3f3f3 solid;
        }
    </style>
    <div class="row">
        <!------ Include the above in your HEAD tag ---------->


        <div class="container mb-5 mt-5">
            <div class="pricing card-deck flex-column flex-md-row mb-3">
                <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-5 card card-pricing popular shadow text-center px-3 mb-4">
                        <span class=" w-60 mx-auto px-4 py-1  bg-primary text-white shadow-sm">Spacedive FREE</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-primary text-center mb-0" data-pricing-value="15"><span class="price">FREE</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                        </div>

                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li class="li-plan">free Demo</li>
                                <li class="li-plan">Send 1st invoice for free</li>
                                <li class="li-plan">Secure payout for your eBooks</li>
                                <li class="li-plan">Full support & guidance</li>
                                <li class="li-plan">(No binding & no setup fee)</li>
                            </ul>
                            <a href="{{url('/payment-1')}}"  class="btn btn-primary mb-3">Order Now</a>
                        </div>
                    </div>
                    <div class="col-lg-5 card card-pricing popular shadow text-center px-3 mb-4">
                        <span class=" w-60 mx-auto px-4 py-1  bg-primary text-white shadow-sm">Spacedive Starter</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-primary text-center mb-0" data-pricing-value="30">Kr.<span class="price">249</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li class="li-plan">Get Started!</li>
                                <li class="li-plan">Send up to 4 invoices</li>
                                <li class="li-plan">Secure payout for your eBooks</li>
                                <li class="li-plan">Full support & guidance</li>
                                <li class="li-plan">(No binding & no setup fee)</li>
                            </ul>
                            <a href="{{url('/payment-2')}}"  class="btn btn-primary mb-3">Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-5 card card-pricing popular shadow text-center px-3 mb-4">
                        <span class=" w-60 mx-auto px-4 py-1  bg-primary text-white shadow-sm">Spacedive Pro</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-primary text-center mb-0" data-pricing-value="45">Kr.<span class="price">399</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li class="li-plan">Rockstar</li>
                                <li class="li-plan">Send up to 8 invoices</li>
                                <li class="li-plan">Secure payout for your eBooks</li>
                                <li class="li-plan">Full support & guidance</li>
                                <li class="li-plan">(No binding & no setup fee)</li>
                            </ul>
                            <a href="{{url('/payment-3')}}"  class="btn btn-primary mb-3">Order Now</a>
                        </div>
                    </div>
                    <div class="col-lg-5 card card-pricing popular shadow text-center px-3 mb-4">
                    <span class=" w-60 mx-auto px-4 py-1  bg-primary text-white shadow-sm">Spacedive XO</span>
                    <div class="bg-transparent card-header pt-4 border-0">
                        <h1 class="h1 font-weight-normal text-primary text-center mb-0" data-pricing-value="60">Kr.<span class="price">799</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                    </div>
                    <div class="card-body pt-0">
                        <ul class="list-unstyled mb-4">
                            <li class="li-plan">Super Pro</li>
                            <li class="li-plan">Send up to 20 invoices</li>
                            <li class="li-plan">Secure payout for your eBooks</li>
                            <li class="li-plan">Full support & guidance</li>
                            <li class="li-plan">(No binding & no setup fee)</li>
                        </ul>
                        <a href="{{url('/payment-4')}}"  class="btn btn-primary mb-3">Order Now</a>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
@endsection
@section('script')
    <script>
        $("#month").datepicker({
            format: "mm",
            minViewMode: 1,
            maxViewMode: 1
        });
        $("#year").datepicker({
            format: "yyyy",
            minViewMode: 2,
            maxViewMode: 2,
        });
    </script>
@endsection
