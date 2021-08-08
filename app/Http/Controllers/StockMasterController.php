<?php

namespace App\Http\Controllers;

use App\Casts\ItemStatus;
use App\Casts\StockStatus;
use App\Casts\UserLevel;
use App\Models\ItemCategory;
use App\Models\MasterItem;
use App\Models\MasterStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class StockMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([
            UserLevel::OWNER,
            UserLevel::WAREHOUSE,
            UserLevel::ADMIN,
        ]));
    }

    public function index()
    {
        $data = MasterStock::with('master_item','master_item.item_category')->get();
        $title = "Stock Master";
        return view('stock-master.index', compact('data','title'));
    }

    public function edit($id)
    {
        $data = MasterStock::with('master_item','master_item.item_category')->get();
        $edit_item = MasterStock::with('master_item','master_item.item_category')->where('id',$id)->first();
        $title = "Stock Master";
        return view('stock-master.index', compact('data','edit_item','title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "qty" => "required",
            "price" => "required",
            "min_stock" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action = MasterStock::where('id',$id)->update([
            'qty' => $data['qty'],
            'sell_price' => $data['price'],
            'min_stock' => $data['min_stock'],
        ]);
        if ($action){
            return redirect()->back()->with(['msg'=>'Data has been updated']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to update']);
    }

    public function opname()
    {
        $data = MasterStock::with('master_item','master_item.item_category')
            ->whereColumn('qty', '<', 'min_stock')->get();
        $title = "Stock Opname";
        return view('stock-master.index', compact('data','title'));
    }
}
