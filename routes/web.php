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


    Route::get('/plans', function () {
        $plans = Plan::all();
        return view('plans',compact("plans"));
    });

    Route::get('/payment-{plan}', function (\App\Plan $plan) {
        return view('payment',compact('plan'));
    });

    Route::get('/register-{plan}', function (\App\Plan $plan) {
        $token = request()->get("_token",'');
        if ($plan->id != 1) {
            $result = \App\Payment::checkPayment($token);
            if ($result) {
                return view('register', compact('token'));
            } else {
                return redirect("/payment-".$plan->id);
            }
        }
        return view('register', compact('token'));
    });

    Route::post('/payment-{plan}', 'AuthController@postPayment');
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
    Route::get('/new_invoice', function () {
        $clients = \App\Client::where('user_id',auth()->id())->get();

        return view('newInvoice',compact('clients'));
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
    Route::post('/profile', 'AuthController@update');
    Route::post('/update-plan', 'AuthController@updatePlan');
    Route::post('/new_invoice', 'InvoiceController@add');
    Route::post('/add_client', 'InvoiceController@add_client');
    Route::post('/edit_client', 'InvoiceController@edit_client');
    Route::get('/del_client/{id}', 'InvoiceController@del_client');
    Route::get('/edit_invoice_{id}', 'InvoiceController@edit');
    Route::get('/invoice_{id}', 'InvoiceController@view');
    Route::post('/edit_invoice_{id}', 'InvoiceController@update');

    Route::get('/logout', 'AuthController@postLogout');

});

