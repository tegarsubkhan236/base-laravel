<?php

namespace App\Http\Controllers;

use App\Casts\ItemStatus;
use App\Casts\StockStatus;
use App\Casts\UserLevel;
use App\Models\ItemCategory;
use App\Models\MasterItem;
use App\Models\MasterStock;
use Illuminate\Http\Request;

class StockMasterController extends Controller
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
        $data = MasterStock::all();
        $title = "Stock Master";
        return view('stock-master.index', compact('data','title'));
    }

    public function edit($id)
    {
        $data = MasterStock::all();
        $edit_item = MasterStock::where('id',$id)->first();
        $title = "Stock Master";
        return view('item-master.index', compact('data','edit_item','title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "qty" => "required",
            "price" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action = MasterStock::where('id',$id)->update([
            'qty' => $data['qty'],
            'sell_price' => $data['price']
        ]);
        if ($action){
            return redirect()->back()->with(['msg'=>'Data has been updated']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to update']);
    }
}
