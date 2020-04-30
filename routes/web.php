<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('login');
    });



    Route::get('/register', function () {
        $token = request()->get("_token",'');
//        if ($plan->id != 1) {
//            $result = \App\Payment::checkPayment($token);
//            if ($result) {
//                return view('register', compact('token'));
//            } else {
//                return redirect("/payment-".$plan->id);
//            }
//        }
        return view('register', compact('token'));
    });

    Route::post('/register', 'AuthController@postRegister');
    Route::post('/login', 'AuthController@postLogin');


    Route::get('/reset_password_{id}', function ($id) {$user = \App\User::find($id); if(!$user){return back();}return view('reset')->with('u_id',$id);});
    Route::get('/forgotPass', function () {return view('forgot');});

    Route::post('/forgotPass', function (\Illuminate\Http\Request $request) {
        $email = $request->email;
        $u = \App\User::where("email",$email)->first();
        if($u){
            $link = url('/reset_password_'.$u->id);
            Mail::send('emails.forgot', ["link"=>$link], function($message) use ($email) {
                $message->to($email, 'User')->subject
                ('Forgot Password');
            });
            return back()->withErrors('Email sent successfully');
        }
        return back()->withErrors('Email not found');
    });
    Route::post('/reset_password_{id}', function ($id,\Illuminate\Http\Request $request) {
        $u = \App\User::find($id);
        if($u){
            $u->password = bcrypt($request->password);
            $u->save();
            return back()->withErrors('Password updated successfully');
        }
        return back()->withErrors('User not found');
    });
});
Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin_notification_read_{id}', function($id) {
        $n = \App\Notification::find($id);
        $n->read = 1;
        $n->save();
        if(!$n->url){
            return redirect('/');
        }
        if(auth()->user()->is_admin){
            return redirect('/admin_invoice_'.$n->url);
        }        return redirect('/invoice_'.$n->url);

    });
    Route::get('/admin', function() {
        $invoices = \App\Invoice::where('final','1')->get();
        $total_users = \App\User::where('is_admin',0)->count();
        $users = \App\User::selectRaw('count(id) as total,plan_id')->where('is_admin',0)->groupBy('plan_id')->get();
        $payments = \App\Payment::selectRaw('sum(amount) as tamount,plan_id')->groupBy('plan_id')->get();
        return view('admin.home',compact('total_users','payments','invoices','users'));
    });

    Route::post('admin_invoice_status', function (\Illuminate\Http\Request $request) {

        $invoice = \App\Invoice::find($request->invoice_id);
        if($invoice){
            $invoice->status = $request->invoice_type;
            $invoice->save();

            \App\Notification::create([
                'user_id' => $invoice->user_id,
                'title' => 'Invoice status changed',
                'data' => $invoice->invoice_num . ' status changed to ' .$invoice->status,
                'url' => $invoice->id
            ]);
        }
        return back();
    });

    Route::get('admin_invoice_status_update_job', function (\Illuminate\Http\Request $request) {
        $invoices = \App\Invoice::whereRaw('json_extract(data, "$.date_due") < ?',[date('Y-m-d')])
            ->where('status','<>','paid')->get();
        foreach ($invoices as $invoice) {
            $invoice->status = 'overdue';
            $invoice->save();
        }
    });
    Route::get('admin_invoices', function (\Illuminate\Http\Request $request) {
        $invoices = \App\Invoice::when($request->user_id,function ($q) use ($request) {
            return $q->where('user_id',$request->user_id);
        });
        if($request->client_id){
            $invoices->where('client_id','=',$request->client_id);
        }
        if($request->type){
            $invoices->where('status','=',$request->type);
        }
        $invoices = $invoices->orderBy('id','DESC')->get();

        $clients = \App\Client::get();
        $users = \App\User::where('is_admin',0)->get();
        return view('admin.invoices',compact('clients','invoices','users'));
    });

    Route::get('/plans', function () {
        $plans = Plan::all();
        return view('plans2',compact("plans"));
    });


    Route::get('/payment-{plan}', function (\App\Plan $plan) {
        $user = auth()->user();
        return view('payment2',compact('user','plan'));
    });
    Route::post('/payment-{plan}', 'AuthController@postPayment');
    Route::get('/endplan', 'AuthController@endPlan');

    Route::get('/', function () {
        $invoices = \App\Invoice::where('user_id',auth()->id())->where('final','1')->get();
        $paid_amount = $invoices->where('status','paid')->sum('total');
        $pend = $invoices->where('status','pending');
        $total = 0;
        foreach ($pend as $item) {
            $item->data = json_decode($item->data);
            if(date('Y-m-d') < date('Y-m-d',strtotime($item->data->date_due))){
                $total = $item->total;
            }
        }
        $graph_data = DB::select("select sum(total) as total, created_at as new_date, YEAR(created_at) year, MONTH(created_at) month from `invoices` where `user_id` = ? group by `year`, `month`",[auth()->id()]);
        $graph2_data = DB::select("select sum(total) as total, created_at as new_date, YEAR(created_at) year, MONTH(created_at) month from `invoices` where status = 'paid' and`user_id` = ? group by `year`, `month`",[auth()->id()]);
        if(count($graph2_data)){
            $a = [(object)[
                "total" => 0,
                "new_date" => date('Y-m-d',strtotime('-1 month',strtotime($graph2_data[0]->new_date)))
            ]];
            $graph2_data = array_merge($a,$graph2_data);
        }
        $clients = \App\Client::select('*')
            ->selectRaw('(select IFNULL(sum(total),0) from invoices where invoices.client_id=clients.id) as invoice_total')
            ->orderBy('invoice_total','desc')
            ->where('user_id',auth()->id())
            ->get(5);
        return view('home',compact('clients','invoices','paid_amount','total','graph_data','graph2_data'));
    });
    Route::get('/invoices', function (\Illuminate\Http\Request $request) {
        $invoices = \App\Invoice::where('user_id',auth()->id());
        if($request->client_id){
            $invoices->where('client_id','=',$request->client_id);
        }
        if($request->type){
            $invoices->where('status','=',$request->type);
        }else{
            $invoices->where('status','!=','draft');
        }
        $invoices = $invoices->orderBy('id','DESC')->get();

        $clients = \App\Client::where('user_id',auth()->id())->get();
        return view('invoices',compact('clients','invoices'));
    });
    Route::get('/search', function (\Illuminate\Http\Request $request) {
        $str = $request->search;
        $invoices = \App\Invoice::where('invoice_num','like','%'.$str.'%')->where('user_id',auth()->id())->get();
        return response()->json($invoices);
    });
    Route::get('/draft_invoices', function () {
        $invoices = \App\Invoice::where('user_id',auth()->id())->where('status','=','draft')->get();
            return view('draftinvoices',compact('invoices'));
    });
    Route::group(['middleware' => 'invoice'], function () {
        Route::get('/new_invoice', function () {
            $clients = \App\Client::where('user_id',auth()->id())->get();
            return view('newInvoice',compact('clients'));
        });
        Route::post('/new_invoice', 'InvoiceController@add');

    });
    Route::get('/clients', function () {
        $clients = \App\Client::where('user_id',auth()->id())->get();

        return view('clients',compact('clients'));
    });
    Route::get('/profile', function () {
        $user = \App\User::find(auth()->id());
        return view('profile',compact('user'));
    });
    Route::get('/payments', function () {
        $payments = \App\Payment::where("user_id",auth()->id())->get();
        return view('my-payments',compact('payments'));
    });
    Route::get('/dashboard', function () {
        $invoices = \App\Invoice::all();

        return view('dashboard',compact('invoices'));
    });
    Route::get('/support', function () {
        return view('support');
    });
    Route::get('/plan2', function () {
        return view('plans2');
    });
    Route::post('/profile', 'AuthController@update');
    Route::post('/update-plan', 'AuthController@updatePlan');
    Route::post('/add_client', 'InvoiceController@add_client');
    Route::post('/edit_client', 'InvoiceController@edit_client');
    Route::get('/del_client/{id}', 'InvoiceController@del_client');
    Route::get('/edit_invoice_{id}', 'InvoiceController@edit');
    Route::post('/delete_invoice_{id}', 'InvoiceController@delete');
    Route::get  ('/delete_invoice_{id}', 'InvoiceController@delete');
    Route::get('/invoice_{id}', 'InvoiceController@view');
    Route::get('/admin_invoice_{id}', 'InvoiceController@adminview');
    Route::post('/edit_invoice_{id}', 'InvoiceController@update');

    Route::get('/logout', 'AuthController@postLogout');
    Route::get('/admin_logout', 'AuthController@postLogout');


    Route::post('/support', function (\Illuminate\Http\Request $request) {
        $email = $request->aboutme;
        Mail::send('emails.support', ["msg"=>$email], function($message) use ($email) {
            $message->to('rasmus@scheuer-larsen.com', 'Support User')->subject
            ('Support ');
        });
        return back()->withErrors('Message send successfully.');
    });
});

