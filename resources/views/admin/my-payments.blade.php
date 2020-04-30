@extends('dashboard',['a' => 'Plan & Payment'])
@section('body')
    <div class="row">
        <div class="col-lg-8">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <div class="row col-lg-12">
                            <div class="col-lg-8">
                                <h3 class="mb-0">Payments</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Sr#</th>
                                <th scope="col" class="sort" data-sort="date">Date</th>
                                <th scope="col" class="sort" data-sort="date">Plan</th>
                                <th scope="col" class="sort" data-sort="amount">Amount (DKK)</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($payments as $payment)
                                <tr>
                                    <th scope="row">
                                        {{$loop->index+1}}
                                    </th>
                                    <td class="budget">
                                        {{$payment->created_at->format("Y-m-d")}}
                                    </td>
                                    <td class="budget">
                                        {{$payment->plan ? $payment->plan->title : ''}}
                                    </td>
                                    <td class="budget">
                                        {{$payment->amount}}
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-profile">

                <div class="card-body pt-0">

                    <div class="text-center">
                        @if(auth()->user()->plan_id)

                        <h5 class="h1">
                            {{auth()->user()->plan ? auth()->user()->plan->title : 'None'}}
                        </h5>
                        <div class="h4 font-weight-300">
                            <i class="ni location_pin mr-2"></i>Current Plan
                        </div>
                        <div class="h5 mt-4">
                            <a href="{{url('/plans')}}"><button class="btn btn-sm btn-info">Upgrade Plan</button></a>
                        </div>
                        <div class="h5 mt-4">
                            <a href="{{url('/endplan')}}" id="end"><button class="btn btn-sm btn-danger">Cancel Subscription</button></a>
                        </div>
                        @else

                            <div class="h5 mt-4">
                                <a href="{{url('/plans')}}"><button class="btn btn-sm btn-info">Upgrade Plan</button></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
        $("#end").click(function(e) {
            if(!confirm('Are you sure you want to cancel your subscription?')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endsection
