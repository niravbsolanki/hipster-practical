<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(){
        return view('admin.auth.register');
    }

    public function registerPost(Request $request){

            $data = $this->validate($request,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $data['password'] = Hash::make($request->password);
            $admin = Admin::create($data);
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
    }
}
