<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Casts\UserStatus;
use App\Models\RoleUser;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([
            UserLevel::OWNER,
        ]));
    }

    public function index()
    {
        $data = Supplier::all();
        $title = "Supplier Management";
        return view('supplier.index', compact('data','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "username" => "required",
            "name" => "required",
            "phone" => "nullable",
            "address" => "nullable",
        ]);
        $data = $request->all();
        unset($data['_token']);

        $userStore = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt(12345),
            'status' => UserStatus::ACTIVE,
        ]);
        if ($userStore){
            $userRole = RoleUser::create([
                'role_id' => UserLevel::SUPPLIER,
                'user_id' => $userStore->id,
            ]);
            if ($userRole){
                $supplier = Supplier::create([
                    'user_id' => $userStore->id,
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                ]);
                if ($supplier){
                    return redirect()->back()->with(['msg'=>'Data has been stored']);
                }
                return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
            }
            return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
    }

    public function edit($id)
    {
        $edit_item = Supplier::where('id',$id)->first();
        $data = Supplier::all();
        $title = "Supplier Management";
        return view('supplier.index', compact('edit_item','data','title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "username" => "required",
            "name" => "required",
            "phone" => "nullable",
            "address" => "nullable",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $find = Supplier::where('id',$id)->first();
        if ($find){
            $supplier = $find->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
            ]);
            if ($supplier){
                $user = User::where('id',$find->user_id)->update([
                    'username' => $data['username']
                ]);
                if ($user){
                    return redirect()->back()->with(['msg'=>'Data has been updated']);
                }
            }
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to update']);
    }
}
