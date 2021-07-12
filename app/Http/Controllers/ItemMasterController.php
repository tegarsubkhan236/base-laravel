<?php

namespace App\Http\Controllers;

use App\Casts\ItemStatus;
use App\Casts\StockStatus;
use App\Casts\UserLevel;
use App\Models\ItemCategory;
use App\Models\MasterItem;
use App\Models\MasterStock;
use Illuminate\Http\Request;

class ItemMasterController extends Controller
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
        $data = MasterItem::with('item_category')->get();
        $category = ItemCategory::all();
        $title = "Item Master";
        return view('item-master.index', compact('data','category','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            'category_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action_master = MasterItem::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'status' => ItemStatus::ACTIVE,
        ]);
        if ($action_master){
            $action_child = MasterStock::create([
                'item_id' => $action_master->id,
                'qty' => $data['qty'],
                'sell_price' => $data['price'],
                'status' => StockStatus::ACTIVE,
            ]);
            if ($action_child){
                return redirect()->back()->with(['msg'=>'Data has been stored']);
            }
            return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
    }

    public function edit($id)
    {
        $data = MasterItem::with('item_category')->get();;
        $edit_item = MasterItem::with('item_category')->where('id',$id)->first();
        $category = ItemCategory::all();
        $title = "Item Master";
        return view('item-master.index', compact('data','edit_item','category','title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            'category_id' => 'required',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action = MasterItem::where('id',$id)->update([
            'name' => $data['name'],
            'category_id' => $data['category_id']
        ]);
        if ($action){
            return redirect()->back()->with(['msg'=>'Data has been updated']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to update']);
    }

    public function destroy($id)
    {
        $action = MasterItem::where('id',$id)->first();
        if ($action){
            $check = MasterStock::where('item_id', $action->id)->first();
            if ($check->qty > 0){
                return redirect()->back()->withErrors(['msg'=>'item still have stock in stock master']);
            }
            $exec = $action->delete();
            if ($exec){
                return redirect()->back()->with(['msg'=>'data deleted successfully']);
            }
        }
        return redirect()->back()->withErrors('error','data not found');
    }
}
