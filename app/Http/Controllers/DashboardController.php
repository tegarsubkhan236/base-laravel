<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        ));
    }

    public function index()
    {
        $title = "Dashboard";
        return view('dashboard',compact('title'));
    }

    public function profile($user_id)
    {
        $account = Auth::user();
        $data = '';
        if (UserLevel::ADMIN){
            $data = '';
        }
        if (UserLevel::USER){
            $data = '';
        }
        return view('profile',compact('data', 'account'));
    }

    public function avatar(Request $request,$user_id)
    {
        $request->validate([
           'avatar' => 'required',
        ]);

        $data = $request->all();
        unset($data['_token']);
        $find = User::where('id', $user_id)->update(['avatar' => $data['avatar']]);
        if ($find){
            return 'success';
        }
        return 'failed';
    }

    public function account(Request $request, $user_id)
    {
        $request->validate([
           'name' => 'required',
           'username' => 'required'
        ]);
        $data = $request->all();
        unset($data['_token']);
        $find = User::where('id', $user_id)->update($data);
        if ($find){
            return 'success';
        }
        return 'failed';
    }
}
