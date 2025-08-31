<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function loginPost(Request $request){

            $request = $this->validate($request,
            [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ]);

            if(Auth::guard('admin')->attempt($request)){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('admin.login')->withErrors(['email'=>'Invalid Email or Password']);
            }
    }
}
