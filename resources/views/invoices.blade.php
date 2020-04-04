@extends('dashboard',['a' => 'Invoices'])
@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <form action="">
                   <div class="row">
                       <div class="col-lg-3">
                           <div class="form-group">
                               <label class="form-control-label" for="input-city">Clients</label>
                               <select name="client_id" class="form-control" id="">
                                   <option value="">Select Client</option>
                                   @foreach($clients as $client)
                                       <option value="{{$client->id}}">{{$client->name}}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-lg-3">
                           <div class="form-group">
                               <label class="form-control-label" for="input-city">Invoice Type</label>
                               <select name="type" class="form-control" id="">
                                   <option value="">Select Type</option>
                                   <option value="draft">Draft</option>
                                   <option value="pending">Pending</option>
                                   <option value="paid">Paid</option>
                               </select>
                           </div>
                       </div>
                       <div class="col-lg-2">
                           <div class="form-group">
                               <label class="form-control-label" for="input-city"> </label>
                               <button class="btn btn-lg btn-primary form-control" name="subBtn" style="background-color: #5354CE !important;">Update</button>
                           </div>
                       </div>
                   </div>
                </form>
                <div class="card-header border-0">
                    <h3 class="mb-0">Invoices</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
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
                                            <a class="dropdown-item" href="#">Delete</a>
                                            @endif
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
