<?php

namespace App\Http\Controllers;

use App\Casts\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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

    public function login(Request $req): RedirectResponse
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
            return back()->withErrors(['msg'=>"Username / Password not valid"]);
        }
        if (Auth::user()->status !== UserStatus::ACTIVE) {
            return back()->withErrors(['msg' => "Account not active"]);
        }
        return redirect()->route('dashboard')->with(['msg'=>"Welcome ". $data['username']]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('/')->with(['msg'=>"Good Bye !!!"]);
    }
}
