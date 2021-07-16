<?php

namespace App\Http\Controllers;

use App\Casts\StockStatus;
use App\Casts\UserLevel;
use App\Models\MasterItem;
use App\Models\MasterStock;
use App\Models\RoleUser;
use App\Models\Supplier;
use App\Models\SupplierStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockSupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([
            UserLevel::OWNER,
            UserLevel::WAREHOUSE,
            UserLevel::SUPPLIER,
        ]));
    }

    public function index()
    {
        $userRole = RoleUser::where('user_id',Auth::id())->first()->role_id;
        if ($userRole == UserLevel::OWNER || $userRole == UserLevel::WAREHOUSE) {
            $supplier = Supplier::all();
            $items = MasterItem::all();
            $title = "Supplier Stock";
            return view('supplier-stock.index', compact('supplier', 'items', 'title'));
        }
        if ($userRole == UserLevel::SUPPLIER){
            $supplier = Supplier::where('user_id',Auth::id())->first();
            $title = $supplier->name." Stock";
            $items = MasterItem::all();
            $data = SupplierStock::with('master_item','master_item.item_category')->where('supplier_id',$supplier->id)->get();
            return view('supplier-stock.index', compact('data', 'title','items'));
        }
        return redirect()->back()->withErrors(['msg'=>'Something Wrong']);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'supplier' => 'nullable',
            'item' => 'nullable',
        ]);
//        return $request->all();
        $req = $request->all();
        unset($req['_token']);
        $supplier = Supplier::all();
        $items = MasterItem::all();
        $title = "Supplier Stock";

        $data = SupplierStock::with('master_item','master_item.item_category')->orderBy('id','desc');
        if ($req['item'] == null && $req['supplier'] == null){
            $title = "All Data Supplier Stock";
        }
        if ($req['supplier'] != null){
            $data->where('supplier_id',$req['supplier']);
        }
        if ($req['item'] != null){
            $data->where('item_id',$req['item']);
        }
        return view('supplier-stock.index', [
            'supplier' => $supplier,
            'items' => $items,
            'title' => $title,
            'data' => $data->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required',
            'qty' => 'required',
            'price' => 'required',
//            'min_stock' => 'required',
        ]);
        $value = $request->all();
        unset($value['_token']);
        $supplier = Supplier::where('user_id',Auth::id())->first();
        $find = SupplierStock::where('supplier_id',$supplier->id);
        if ($find){
            if (in_array($value['item'], $find->pluck('item_id')->toArray())){
                $itemName = MasterItem::where('id',$value['item'])->first();
                return redirect()->back()->withErrors(['msg'=>'You already have '.$itemName['name'].' in your stock']);
            }
        }

        $store = SupplierStock::create([
            'supplier_id' => $supplier->id,
            'item_id' => $value['item'],
            'qty' => $value['qty'],
//            'min_stock' => $value['min_stock'],
            'sell_price' => $value['price'],
            'status' => StockStatus::ACTIVE,
        ]);
        if ($store){
            return redirect()->back()->with(['msg'=>'Data has been stored']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to store']);
    }

    public function edit($id)
    {
        $items = MasterItem::all();
        $data = SupplierStock::with('master_item','master_item.item_category')->get();
        $edit_item = SupplierStock::with('master_item','master_item.item_category')->where('id',$id)->first();
        $supplier = Supplier::where('user_id',Auth::id())->first();
        $title = $supplier->name." Stock";
        return view('supplier-stock.index', compact('data','edit_item','title','items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "qty" => "required",
            "price" => "required",
//            "min_stock" => "required",
        ]);
        $data = $request->all();
        unset($data['_token']);
        $action = SupplierStock::where('id',$id)->update([
            'qty' => $data['qty'],
            'sell_price' => $data['price'],
//            'min_stock' => $data['min_stock'],
        ]);
        if ($action){
            return redirect()->back()->with(['msg'=>'Data has been updated']);
        }
        return redirect()->back()->withErrors(['msg'=>'Data failed to update']);
    }
}
