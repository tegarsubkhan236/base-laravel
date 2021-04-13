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
        $this->middleware($this->allowedAccess([UserLevel::SUPER_ADMIN]));
    }

    public function user()
    {
        $title = 'User';
        $data = User::with('roles')->paginate(10);
        $listRole = Role::all();
        $data->filter(function ($v){
           $v->status_text = UserStatus::lang($v->status);
        });
        return view("super.user_index",compact('data','listRole','title'));
    }

    public function user_store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "username" => "required",
            "password" => "required",
            "role_id" => "required",
        ]);
        $data = $request->all();
        $data['status'] = 1;
        unset($data['_token']);
        $role = $data['role_id'];
        $userStore = User::create($data);
        if ($userStore){
            $userRole = RoleUser::create([
                'role_id' => $role,
                'user_id' => $userStore->id,
            ]);
            if ($userRole){
                return redirect()->back()->with(['msg'=>'Data has been stored']);
            }
            return redirect()->back()->with(['msg'=>'Data has been stored']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
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

    public function user_destroy(Request $request)
    {
        User::find($request->id)->delete();
        return redirect()->back()->with('success','User deleted successfully');
    }

    public function role()
    {
        $title = "Role";
        $data = Role::paginate(10);
        return view('super.role_index',compact('data','title'));
    }

    public function role_store(Request $request)
    {
        $request->validate([
           "name" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $store = Role::create($data);
        if ($store){
            return redirect()->back()->with(['msg'=>'Data berhasil di simpan']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data gagal di simpan']);
    }

    public function role_update(Request $request, $role_id)
    {
        $request->validate([
           "name" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $update = Role::where('id',$role_id)->update($data);
        if ($update){
            return redirect()->back()->with(['msg'=>'Data berhasil di update']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data gagal di update']);
    }
}
