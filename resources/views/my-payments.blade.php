@extends('dashboard',['a' => 'Payments'])
@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Payments</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Sr#</th>
                            <th scope="col" class="sort" data-sort="date">Date</th>
                            <th scope="col" class="sort" data-sort="amount">Amount ($)</th>
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


@endsection
