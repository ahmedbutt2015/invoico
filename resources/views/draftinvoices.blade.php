@extends('dashboard',['a' => 'My Drafts'])
@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">My Drafts</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive" style="min-height: 200px">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Sr#</th>
                            <th scope="col" class="sort" data-sort="name">Invoice No.</th>
                            <th scope="col" class="sort" data-sort="budget">Client</th>
                            <th scope="col" class="sort" data-sort="status">Total</th>
                            <th scope="col" class="sort" data-sort="status">Status</th>
                            <th scope="col" class="sort" data-sort="status">Due Date</th>
                                <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($invoices as $invoice)
                            <tr>
                                <th scope="row">
                                    {{$loop->index+1}}
                                </th>
                                <td class="budget">

                                    <a href="{{url('/invoice_'.$invoice->id)}}">{{$invoice->invoice_num}}</a>
                                </td>
                                <td class="budget">
                                    {{$invoice->client}}
                                </td>
                                <td class="budget">
                                    {{$invoice->total}}
                                </td>
                                <td class="budget">
                                    {{ucwords($invoice->status)}}
                                </td>
                                <td class="budget">
                                    {{json_decode($invoice->data)->date_due}}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{url('/invoice_'.$invoice->id)}}">View</a>
                                            @if(!$invoice->final)
                                            <a class="dropdown-item" href="{{url('/edit_invoice_'.$invoice->id)}}">Edit</a>
                                            @endif
                                            <a class="delInvoice dropdown-item" href="{{url('/delete_invoice_'.$invoice->id)}}">Delete</a>
                                        </div>
                                    </div>
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
@section('script')
    <script>

        $(".delInvoice").click(function(e) {
            if(!confirm('Are you sure you want to delete this invoice?')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endsection
