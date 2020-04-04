@extends('dashboard',['a' => 'Home'])
@section('body')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats" style="height: 200px">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Invoice Amount</h5>
                            <span class="h2 font-weight-bold mb-0">{{$invoices->sum('total')}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-credit-card"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats"  style="height: 200px">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Invoices Send</h5>
                            <span class="h2 font-weight-bold mb-0">{{count($invoices)}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats"  style="height: 200px">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Payment
                                received</h5>
                            <span class="h2 font-weight-bold mb-0">{{$paid_amount}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-collection"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats"  style="height: 200px">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Payment Overdue</h5>
                            <span class="h2 font-weight-bold mb-0">{{$total}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Graph</h6>
                            <h5 class="h3 mb-0">Amount invoiced</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card bg-default">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>
                            <h5 class="h3 text-white mb-0">Payment Received</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="chart-sales-dark2" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Top 5 Client</h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Invoice Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <th scope="row">
                                {{$client->name}}
                            </th>
                            <td>
                                {{$client->invoice_total}}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>
    date_arr = []
    amount_arr = []
</script>
    @foreach($graph_data as $data)
        <script>amount_arr.push("{{$data->total}}")</script>
        <script>date_arr.push("{{date('M',strtotime($data->new_date))}}")</script>
    @endforeach
<script>
    date_arr2 = []
    amount_arr2 = []
</script>
    @foreach($graph2_data as $data)
        <script>amount_arr2.push("{{$data->total}}")</script>
        <script>date_arr2.push("{{date('M',strtotime($data->new_date))}}")</script>
    @endforeach
@endsection
@section('script')
    <script>

        console.log(date_arr)
        var BarsChart = function () {
            var a = $("#chart-bars");
            a.length && function (a) {
                var t = new Chart(a, {
                    type: "bar",
                    data: {
                        labels: date_arr,
                        datasets: [{label: "Amount", data:  amount_arr}]
                    }
                });
                a.data("chart", t)
            }(a)
        }();

        var $chart = $('#chart-sales-dark2');
        var salesChart = new Chart($chart, {
            type: 'line',
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            lineWidth: 1,
                            color: Charts.colors.gray[900],
                            zeroLineColor: Charts.colors.gray[900]
                        }
                    }]
                }
            },
            data: {
                labels: date_arr2,
                datasets: [{
                    label: 'Performance',
                    data: amount_arr2
                }]
            }
        });

        // var salesChart = new Chart($('#chart-sales-dark2'), {
        //     type: 'line',
        //     options: {
        //         scales: {
        //             yAxes: [{
        //                 gridLines: {
        //                     lineWidth: 1,
        //                     color: Charts.colors.gray[900],
        //                     zeroLineColor: Charts.colors.gray[900]
        //                 },
        //                 ticks: {
        //                     callback: function(value) {
        //                         if (!(value % 10)) {
        //                             return '$' + value + 'k';
        //                         }
        //                     }
        //                 }
        //             }]
        //         },
        //         tooltips: {
        //             callbacks: {
        //                 label: function(item, data) {
        //                     var label = data.datasets[item.datasetIndex].label || '';
        //                     var yLabel = item.yLabel;
        //                     var content = '';
        //
        //                     if (data.datasets.length > 1) {
        //                         content += '<span class="popover-body-label mr-auto">' + label + '</span>';
        //                     }
        //
        //                     content += '<span class="popover-body-value">$' + yLabel + 'k</span>';
        //                     return content;
        //                 }
        //             }
        //         }
        //     },
        //     data: {
        //         labels: date_arr2,
        //         datasets: [{
        //             label: 'Performance',
        //             data: amount_arr2
        //         }]
        //     }
        // });

        // Save to jQuery object

        $chart.data('chart', salesChart);

    </script>
@endsection
