<?php

namespace App\Http\Controllers;

use App\Casts\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_page()
    {
        return view('login');
    }

    public function register_page()
    {
        return view('register');
    }

    public function register()
    {
        //
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
          "status" => UserStatus::ACTIVE,
        ];
        if (! Auth::attempt($credentials)){
            return redirect()->route('/');
        }
        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/');
    }
}
