<?php

namespace App\Http\Controllers;

use App\Casts\BuyStatus;
use App\Casts\UserLevel;
use App\Models\BuyTransaction;
use App\Models\BuyTransactionDetail;
use App\Models\MasterItem;
use App\Models\MasterStock;
use App\Models\RoleUser;
use App\Models\Supplier;
use App\Models\SupplierStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([
            UserLevel::WAREHOUSE,
            UserLevel::OWNER,
            UserLevel::SUPPLIER
        ]));
    }

    public function index()
    {
        $title = 'Buy Transaction';
        $masterItem = MasterItem::all();
        $supplier = Supplier::all();
        return view('buy.index', compact('title', 'masterItem', 'supplier'));
    }

    public function search_supplier(Request $request)
    {
        $request->validate([
            'supplier' => 'required'
        ]);
        $title = 'Buy Transaction';
        $supplier = Supplier::all();
        $data = $request->all();
        $search_result = Supplier::where('id', $data['supplier'])->first();
        $masterItem = SupplierStock::with('master_item')->where('supplier_id', $data['supplier'])->get();

        return view('buy.index', compact('title', 'masterItem', 'supplier', 'search_result'));
    }

    public function detail_item($id, $supplier_id)
    {
        $data = SupplierStock::with('master_item')
            ->where('item_id', $id)
            ->where('supplier_id', $supplier_id)
            ->first();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id.*' => 'required|distinct',
            'qty.*' => 'required',
            'note' => 'nullable',
            'supplier_id' => 'required',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $countItem = count($data['item_id']);

        // check if stock available and make sure stock not in min stock after transaction
        for ($i = 0; $i < $countItem; $i++) {
            $stock = SupplierStock::with('master_item')
                ->where('item_id', $data['item_id'][$i])
                ->where('supplier_id', $data['supplier_id'])
                ->first();

            if ($stock['qty'] - $data['qty'][$i] < 0) {
                return redirect()->back()->withErrors(['msg' => "Stock not available for " . $stock['master_item']['name']]);
            }
        }
        $createParent = BuyTransaction::create([
            'user_id' => Auth::id(),
            'supplier_id' => $data['supplier_id'],
            'status' => BuyStatus::Pending,
            'note' => $data['note'],
        ]);
        if ($createParent) {
            for ($i = 0; $i < $countItem; $i++) {
                $stock = SupplierStock::with('master_item')
                    ->where('item_id', $data['item_id'][$i])
                    ->where('supplier_id', $data['supplier_id'])
                    ->first();
                if ($stock) {
                    BuyTransactionDetail::create([
                        'transaction_id' => $createParent->id,
                        'stock_id' => $stock->id,
                        'qty' => $data['qty'][$i],
                    ]);
                }
            }
        }
        return redirect()->back()->with(['msg' => 'Data has been stored']);
    }

    public function buy_report()
    {
        $supplier = Supplier::all();
        $userRole = RoleUser::where('user_id',Auth::id())->first()->role_id;
        if ($userRole == UserLevel::WAREHOUSE || $userRole == UserLevel::OWNER){
            $data = BuyTransaction::with('supplier', 'buy_transaction_details', 'buy_transaction_details.supplier_stock', 'buy_transaction_details.supplier_stock.master_item')
                ->orderBy('id', 'DESC')
                ->get();
        }
        if ($userRole == UserLevel::SUPPLIER) {
            $supplier = Supplier::where('user_id',Auth::id())->first();
            $data = BuyTransaction::with('supplier', 'buy_transaction_details', 'buy_transaction_details.supplier_stock', 'buy_transaction_details.supplier_stock.master_item')
                ->where('supplier_id',$supplier->id)
                ->orderBy('id', 'DESC')
                ->get();
        }
        foreach ($data as $v) {
            $total = [];
            for ($i = 0; $i < count($v->buy_transaction_details); $i++) {
                $total[$i] = $v->buy_transaction_details[$i]->qty * $v->buy_transaction_details[$i]->supplier_stock->sell_price;
            }
            $v->total = array_sum($total);
        }
        $title = 'Buy Report';
        return view('buy-report.index', compact('data', 'title', 'supplier'));
    }

    public function buy_report_update_status(Request $request,$id)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $detail = BuyTransactionDetail::with('supplier_stock','supplier_stock.master_item')->where('transaction_id', $id)->get();

        // update by supplier
        if ($data['status'] == BuyStatus::OnGoing){
            $supplier = Supplier::where('user_id',Auth::id())->first();
            for ($i = 0; $i < count($detail); $i++){
                $supplier_stock = SupplierStock::where('supplier_id', $supplier->id)->where('item_id', $detail[$i]['supplier_stock']['master_item']['id'])->first();
                $supplier_stock->qty = $supplier_stock->qty-$detail[$i]['qty'];
                $supplier_stock->save();
            }
        }
        // update by warehouse
        if ($data['status'] == BuyStatus::Complete){
            for ($i = 0; $i < count($detail); $i++) {
                $stock = MasterStock::where('item_id', $detail[$i]['supplier_stock']['master_item']['id'])->first();
                $stock->qty = $stock->qty + $detail[$i]['qty'];
                $stock->save();
            }
        }

        $action = BuyTransaction::where('id',$id)->update([
            'status' => $data['status'],
        ]);
        if ($action) {
            return redirect()->back()->with(['msg' => 'Record updated successfully']);
        }
        return redirect()->back()->withErrors('error', 'Record failed to update');
    }

    public function buy_report_filter(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'start-date' => 'required',
            'end-date' => 'required',
        ]);
        $supplier = Supplier::all();
        $req_item = $request->all();
        $data = BuyTransaction::with('supplier', 'buy_transaction_details', 'buy_transaction_details.supplier_stock', 'buy_transaction_details.supplier_stock.master_item')
            ->where('supplier_id', $req_item['supplier_id'])
            ->where('created_at', '>=', $req_item['start-date'])
            ->where('created_at', '<=', $req_item['end-date'])
            ->get();
        $title = 'Buy Report';
        return view('buy-report.index', compact('data', 'title', 'req_item', 'supplier'));
    }

    public function buy_report_destroy($id)
    {
        $action = BuyTransaction::where('id', $id)->delete();
        if ($action) {
            return redirect()->back()->with(['msg' => 'Record deleted successfully']);
        }
        return redirect()->back()->withErrors('error', 'Record failed to delete');
    }
}
