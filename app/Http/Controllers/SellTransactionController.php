<?php

namespace App\Http\Controllers;

use App\Casts\SellStatus;
use App\Casts\UserLevel;
use App\Models\MasterItem;
use App\Models\MasterStock;
use App\Models\SellTransaction;
use App\Models\SellTransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->allowedAccess([
            UserLevel::ADMIN,
            UserLevel::OWNER,
        ]));
    }

    public function index()
    {
        $title = 'Sell Transaction';
        $masterItem = MasterItem::all();
        return view('sell.index', compact('masterItem', 'title'));
    }

    public function detail_item($id)
    {
        $data = MasterStock::where('id', $id)->first();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id.*' => 'required',
            'qty.*' => 'required',
            'note' => 'nullable',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $countItem = count($data['item_id']);

        // check if stock available and make sure stock not in min stock after transaction
        for ($i = 0; $i < $countItem; $i++) {
            $stock = MasterStock::with('master_item')->where('item_id', $data['item_id'][$i])->first();

            if ($stock['qty'] - $data['qty'][$i] < $stock['min_stock']){
                return redirect()->back()->withErrors(['msg' => 'Min Stock for '.$stock['master_item']['name']]);
            }
            if ($stock['qty'] - $data['qty'][$i] < 0) {
                return redirect()->back()->withErrors(['msg' => "Stock not available for ".$stock['master_item']['name']]);
            }
        }

        $createParent = SellTransaction::create([
            'user_id' => Auth::id(),
            'status' => SellStatus::Complete,
            'note' => $data['note'],
        ]);
        if ($createParent) {
            for ($i = 0; $i < $countItem; $i++) {
                $stock = MasterStock::where('item_id', $data['item_id'][$i])->first();
                $stock->qty = $stock->qty - $data['qty'][$i];
                if ($stock->save()) {
                    SellTransactionDetail::create([
                        'transaction_id' => $createParent->id,
                        'stock_id' => $data['item_id'][$i],
                        'qty' => $data['qty'][$i],
                    ]);
                }
            }
        }
        return redirect()->back()->with(['msg' => 'Data has been stored']);
    }

    public function sell_report()
    {
        $data = SellTransaction::with('user', 'sell_transaction_details', 'sell_transaction_details.master_stock', 'sell_transaction_details.master_stock.master_item')
            ->orderBy('id', 'DESC')
            ->get();
        foreach ($data as $v) {
            $total = [];
            for ($i = 0; $i < count($v->sell_transaction_details); $i++) {
                $total[$i] = $v->sell_transaction_details[$i]->qty * $v->sell_transaction_details[$i]->master_stock->sell_price;
            }
            $v->total = array_sum($total);
        }
        $title = 'Sell Report';
        return view('sell-report.index', compact('data', 'title'));
    }

    public function sell_report_filter(Request $request)
    {
        $request->validate([
            'start-date' => 'required',
            'end-date' => 'required',
        ]);
        $req_item = $request->all();
        $data = SellTransaction::with('user', 'sell_transaction_details', 'sell_transaction_details.master_stock', 'sell_transaction_details.master_stock.master_item')
            ->where('created_at','>=', $req_item['start-date'])
            ->where('created_at', '<=', $req_item['end-date'])
            ->get();
        foreach ($data as $v) {
            $total = [];
            for ($i = 0; $i < count($v->sell_transaction_details); $i++) {
                $total[$i] = $v->sell_transaction_details[$i]->qty * $v->sell_transaction_details[$i]->master_stock->sell_price;
            }
            $v->total = array_sum($total);
        }
        $title = 'Sell Report';
        return view('sell-report.index', compact('data', 'title', 'req_item'));
    }
}
