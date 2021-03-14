<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess(
            [
                UserLevel::SUPER_ADMIN,
                UserLevel::ADMIN,
                UserLevel::USER,
            ]
        ))->only('index');
    }

    public function index()
    {
        $title = "Dashboard";
        return view('dashboard',compact('title'));
    }
}
