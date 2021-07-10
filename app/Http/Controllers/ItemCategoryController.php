<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([
            UserLevel::OWNER,
            UserLevel::WAREHOUSE
        ]));
    }

    public function index()
    {
        $data = ItemCategory::all();
        $title = "Item Category";
        return view('item-category.index', compact('data','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action = ItemCategory::create($data);
        if ($action){
            return redirect()->back()->with(['msg'=>'Data has been stored']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
    }

    public function edit($id)
    {
        $data = ItemCategory::all();
        $edit_item = ItemCategory::where('id',$id)->first();
        $title = "Item Category";
        return view('item-category.index', compact('data','title','edit_item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action = ItemCategory::where('id',$id)->update($data);
        if ($action){
            return redirect()->back()->with(['msg'=>'Data has been updated']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to update']);
    }

    public function destroy(Request $request)
    {
        ItemCategory::find($request->id)->delete();
        return redirect()->back()->with('success','data deleted successfully');
    }
}
