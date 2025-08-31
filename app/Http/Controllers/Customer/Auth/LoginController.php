<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('customer.auth.login');
    }

    public function loginPost(Request $request){

            $request = $this->validate($request,
            [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ]);

            if(Auth::guard('customer')->attempt($request)){
                return redirect()->route('customer.dashboard');
            }else{
                return redirect()->route('customer.login')->withErrors(['email'=>'Invalid Email or Password']);
            }
    }
}
