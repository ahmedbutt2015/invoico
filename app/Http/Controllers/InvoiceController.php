<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function add_client(Request $request){
        $data = $request->all();
        Client::create($request->except('_token'));
        return back();
    }
    public function edit_client(Request $request){
        $data = $request->all();
        $client = Client::find($data['id']);
        $client->name = $data['name'];
        $client->num = $data['num'];
        $client->address = $data['address'];
        $client->cname = $data['cname'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->save();
        return back();
    }
    public function del_client($id){
        Client::find($id)->delete();
        return back();
    }
    public function add(Request $request){

        $data = $request->all();
        $i = Invoice::create([
            'invoice_num'=>$data['invoice_num'],
            'client_id'=>$data['client_id'],
            'client'=>$data['client'],
            'data'=>json_encode($request->except('logo')),
            'total'=>$data['total_val'],
            'final'=>$data['submit'] == 'send' ? 1 : 0,
            'status'=>$data['submit'] == 'send' ? 'pending' : 'draft',
            'user_id'=>auth()->id()
        ]);
        if($request->hasFile('logo')){
            $imageName = time() . '.' . request()->logo->getClientOriginalExtension();
            $i->logo = $imageName;
            $i->save();
            request()->logo->move(public_path('images/user/'), $imageName);
        }

        \App\Notification::create([
            'user_id' => 7,
            'title' => 'New Invoice Created',
            'data' => auth()->user()->fname . ' created new invoice.',
            'url' => $i->id
        ]);

        if($data['submit'] == 'send'){
            return redirect('/invoice_'.$i->id)->withErrors('Congratulations your invoice has been send to Spacedive pending review. We will notify you as soon as we have confirmed and send the invoice to your client.');
        }
        return redirect('/invoice_'.$i->id);
    }
    public function view($id,Request $request){
        $data = $request->all();
        $invoice = Invoice::find($id);
        $invoice->data = json_decode($invoice->data);
        $clients = \App\Client::where('user_id',auth()->id())->get();

//        dd($invoice);
        return view('invoiceView',compact('invoice','clients'));
    }
    public function adminview($id,Request $request){
        $data = $request->all();
        $invoice = Invoice::find($id);
        $invoice->data = json_decode($invoice->data);
        $clients = \App\Client::where('user_id',auth()->id())->get();

//        dd($invoice);
        return view('admin.invoiceView',compact('invoice','clients'));
    }
    public function edit($id,Request $request){
        $data = $request->all();
        $invoice = Invoice::find($id);
        $invoice->data = json_decode($invoice->data);
        $clients = \App\Client::where('user_id',auth()->id())->get();

//        dd($invoice);
        return view('invoiceEdit',compact('invoice','clients'));
    }
    public function delete($id,Request $request){
        $data = $request->all();
        $invoice = Invoice::find($id);
        if($invoice)
        $invoice->delete();
        return redirect('/draft_invoices')->withErrors('Invoice deleted successfully.');
    }
    public function update(Request $request){
        $data = $request->all();
        $invoice = Invoice::find($data['id']);
        $invoice->client = $data['client'];
        $invoice->client_id = $data['client_id'];
        $invoice->total = $data['total'];
        if($data['submit'] == 'send'){
            $invoice->final = 1;
            $invoice->status = 'pending';
        }else{
            $invoice->final = 0;
            $invoice->status = 'draft';
        }
        $invoice->data = json_encode($data);
        $invoice->save();

        if($request->hasFile('logo')){
            $imageName = time() . '.' . request()->logo->getClientOriginalExtension();
            $invoice->logo = $imageName;
            $invoice->save();
            request()->logo->move(public_path('images/user/'), $imageName);
        }
//        dd($invoice);
        return redirect('/invoice_'.$invoice->id);
    }
}
