<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([UserLevel::SUPER_ADMIN]))
            ->only('index');
    }

    public function index()
    {
        $title = "Dashboard";
        return view('dashboard',compact('title'));
    }
}
