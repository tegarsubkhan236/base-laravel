<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([UserLevel::SUPER_ADMIN]))
            ->only('user','role','role_user');
    }

    public function user()
    {
        return view('dashboard');
    }

    public function role()
    {
        return view('dashboard');
    }

    public function role_user()
    {
        return view('dashboard');
    }
}
