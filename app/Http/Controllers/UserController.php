<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
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
        $data = User::all();
        return view("super.user_index",compact('data'));
    }

    public function role()
    {
        $data = Role::all();
        return view('super.role_index',compact('data'));
    }

    public function role_user()
    {
        $data = RoleUser::with('user','role')->get();
        return view('super.userRole_index',compact('data'));
    }
}
