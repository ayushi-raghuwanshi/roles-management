<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email'=> 'required|email',
                'password'=>'required'
            ]
        );
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $request->session()->put('user_email',$request->email);
            $request->session()->put('user_name',Auth::user()->name);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email'=>'Credentials not matching'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login')->with('success','User Logged Out Successfully!');
    }

    public function loginAsOtherUser(Request $request)
    {
        Auth::loginUsingId($request->get('id'));
        $request->session()->put('user_email',$request->email);
        $request->session()->put('user_name',Auth::user()->name);
        return redirect()->route('dashboard');
    }
}
