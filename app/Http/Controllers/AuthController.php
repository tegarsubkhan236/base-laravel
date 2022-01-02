<?php

namespace App\Http\Controllers;

use App\Casts\UserStatus;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register(): void
    {
        //
    }

    public function login_page()
    {
        return view('Auth.login');
    }

    public function login(Request $req)
    {
        $req->validate([
            "username" => "required",
            "password" => "required",
        ]);
        $data = $req->all();
        $credentials = [
            "username" => $data['username'],
            "password" => $data['password'],
        ];
        if (! Auth::attempt($credentials)){
            return back()->withErrors(['error'=>"Username / Password not valid"]);
        }
        if (Auth::user()->status !== UserStatus::ACTIVE) {
            return back()->withErrors(['warning' => "Account not active"]);
        }
        return redirect()->route('home')->with(['message'=>"Welcome ". $credentials['username']]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('/')->with(['msg'=>"Good Bye :)"]);
    }
}
