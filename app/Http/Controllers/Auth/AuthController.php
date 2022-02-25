<?php

namespace App\Http\Controllers\Auth;

use App\Casts\UserStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register()
    {

    }

    public function login_page()
    {
        return view('landing.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $data = $request->all();
        $credentials = [
            "name" => $data['username'],
            "password" => $data['password'],
        ];
        if (! Auth::attempt($credentials)){
            return back()->withErrors(['error'=>"Username / Password not valid"]);
        }
        if (Auth::user()->status !== UserStatus::ACTIVE) {
            return back()->withErrors(['warning' => "Account not active"]);
        }
        return redirect()->route('dashboard')->with(['message'=>"Welcome ". $credentials['name']]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('/')->with(['msg'=>"Good Bye :)"]);
    }
}
