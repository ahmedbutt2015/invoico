<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }

        $user = User::create([
            "fname" => $data["fname"],
            "lname" => $data["lname"],
            "email" => $data["email"],
            "number" => $data["phone"],
            "password" => Hash::make($data["password"])
        ]);
        Auth::login($user);
        return back();
    }
    public function postLogin(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:3'],
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $user = User::where("email",$request->email)->first();
        if ($user) {
            if(Hash::check(request()->get('password'), $user->password)) {
                Auth::login($user);
                return back();
            } else {
                return back()->withErrors(['Password is incorrect']);
            }
        }
        else {
            return back()->withErrors(['Email not found']);

        }

    }

    public function postLogout () {
        auth()->logout();
        return redirect("/");
    }

    public function update (Request $request) {
        $data = $request->except('_token','image');
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
        if($request->password != "%change-password-key%"){
            $user->password = Hash::make($request->password);
        }
        $user->gender = $request->gender;
        $user->aboutme = $request->aboutme;
        if($request->hasFile('image')){
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            $user->image = $imageName;
            request()->image->move(public_path('images/user/'), $imageName);
        }
        $user->save();

        return back();
    }

}
