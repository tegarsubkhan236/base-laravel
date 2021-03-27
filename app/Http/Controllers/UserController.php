<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Casts\UserStatus;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([UserLevel::SUPER_ADMIN]))
            ->only('user','user_toggleStatus','role','role_user');
    }

    public function user()
    {
        $title = 'User';
        $data = User::paginate(10);
        $data->filter(function ($v){
           $v->status_text = UserStatus::lang($v->status);
        });
        return view("super.user_index",compact('data','title'));
    }

    public function user_toggleStatus(Request $request)
    {
        if ($request->user_id == 1){
            return response()->json(['success'=>"Super admin always active"]);
        }
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success'=>'User status change successfully.']);
    }

    public function role()
    {
        $title = "Role";
        $data = Role::paginate(10);
        return view('super.role_index',compact('data','title'));
    }

    public function role_user()
    {
        $title = "Role and User";
        $data = RoleUser::with('user','role')->get();
        return view('super.userRole_index',compact('data','title'));
    }
}
