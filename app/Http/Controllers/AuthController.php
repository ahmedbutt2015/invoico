<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Payment;
use App\Plan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function postRegister(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'lname' => ['required', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3'],
            'terms' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $user_insert = [
            "fname" => $data["fname"],
            "lname" => $data["lname"],
            "email" => $data["email"],
            "number" => $data["phone"],
            "password" => Hash::make($data["password"])
        ];
//        $token = $request->get("registration_token");
//        $record = DB::table("payment_for_registration")->where("token", $token)->first();
//        if ($record) {
//            $user_insert['card_number'] = $record->card;
//            $user_insert['cvc'] = $record->cvc;
//            $user_insert['ex_month'] = $record->month;
//            $user_insert['ex_year'] = $record->year;
//            $user_insert['plan_id'] = $record->plan_id;
//        } else {
//        }
        $user_insert['plan_id'] = 1;

        $user = User::create($user_insert);

        \App\Notification::create([
            'user_id' => 7,
            'title' => 'New User Registered',
            'data' => $user->fname . ' registered',
            'url' => null
        ]);

//        if ($record) {
//            $payment = [
//                "amount" => $record->amount,
//                "card_number" => $record->card,
//                "cvc" => $record->cvc,
//                "month" => $record->month,
//                "year" => $record->year,
//            ];
//            Payment::AddPayment($payment, $user->id);
//            DB::table("payment_for_registration")->where("token", $token)->delete();
//        }
        Auth::login($user);
        return redirect("/");
    }

    public function postLogin(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:3'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $user = User::where("email", $request->email)->first();
        if ($user) {
            if (Hash::check(request()->get('password'), $user->password)) {
                Auth::login($user);
                return back();
            } else {
                return back()->withErrors(['Password is incorrect']);
            }
        } else {
            return back()->withErrors(['Email not found']);

        }

    }

    public function postLogout()
    {
        auth()->logout();
        return redirect("/");
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', 'image');
        $user = User::find($request->id);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->street = $request->street;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->zipcode = $request->zipcode;
        $user->card_number = $request->card_number;
        $user->cvc = $request->cvc;
        $user->ex_month = $request->ex_month;
        $user->ex_year = $request->ex_year;
        if ($request->password != "%change-password-key%") {
            $user->password = Hash::make($request->password);
        }
        $user->gender = $request->gender;
        $user->aboutme = $request->aboutme;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            $user->image = $imageName;
            request()->image->move(public_path('images/user/'), $imageName);
        }
        $user->save();

        return back();
    }

    public function postPayment(PaymentRequest $request, Plan $plan)
    {
        $amount = $plan->amount;
        $plan_id = $plan->id;
        $data = $request->all();
        if($plan_id != 1){

            $result = Payment::payStripe($data, $amount, "Registration Payment to " . config('app.name'), function () use ($data, $plan_id, $amount) {
                $token = Str::random(60);

                $result = DB::table("payment_for_registration")->insert([
                    "token" => $token,
                    "plan_id" => $plan_id,
                    "amount" => $amount,
                    "status" => "paid",
                    "card" => $data['card'],
                    "cvc" => $data['cvc'],
                    "month" => $data['month'],
                    "year" => $data['year'],
                ]);
                if ($result) {
                    return $token;
                } else {
                    return false;
                }
            });
        }

        if ($plan_id == 1 || ($result && $result['type'] == "paid")) {
            $payment = [
                "amount" => $amount,
                "plan_id" => $plan_id,
                "card_number" => $data['card'],
                "cvc" => $data['cvc'],
                "month" => $data['month'],
                "year" => $data['year'],
            ];
            Payment::AddPayment($payment, auth()->id());
            $user = User::find(auth()->id());
            $user->plan_id = $plan_id;
            $user->save();
            return redirect("/")->withErrors('Congratulation ! Your profile has been updated to '.$plan->title.'.');
        } else {
            return back()->withErrors($result['msg']);
        }
    }

    public function updatePlan (Request $request) {
        $user = User::find(auth()->id());
        $user->plan_id = $request->plan_id;
        $user->save();
        return back();
    }

    public function endPlan (Request $request) {
        $user = User::find(auth()->id());
        $user->plan_id = null;
        $user->save();

        \App\Notification::create([
            'user_id' => 7,
            'title' => 'User cancel subscription',
            'data' => $user->email . ' cancel their subscription',
            'url' => null
        ]);
        return back()->withErrors('Congratulation ! Your Subscription has been canceled successfully.');;
    }
}
