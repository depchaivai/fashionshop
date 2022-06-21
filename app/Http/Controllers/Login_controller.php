<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login_controller extends Controller
{
    public function index(){
        if (Auth::check()) {
            if (Auth::user()->enduser) {
                return redirect()->intended('/');
            }
            return redirect()->intended('/dashboard/don-hang');
        }
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->enduser==true){
                return redirect()->intended('/');
            }
            return redirect()->intended('/dashboard/don-hang');
        }
 
        return back()->withErrors([
            'name' => 'sai tài khoản hoặc mật khẩu',
        ])->onlyInput('name');
    }
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required','min:6','unique:users','regex:/^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/i'],
            'email' => ['required','email'],
            'password' => ['required','confirmed','min:6'],
        ]);
        User::create([
            "name"=>$credentials['name'],
            "email"=>$credentials['email'],
            "password"=>bcrypt($credentials['password']),
        ]);
        return redirect()->intended('/');
    }
    public function logout(){
        Auth::logout();
        return redirect()->intended('/');
    }
}
