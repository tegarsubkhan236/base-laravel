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

        // check if stock available
        for ($i = 0; $i < $countItem; $i++) {
            $stock = MasterStock::where('id', $data['item_id'][$i])->first();
            if ($stock->qty - $data['qty'][$i] < 0) {
                return redirect()->back()->withErrors(['msg' => 'Stock not available']);
            }
        }

        $createParent = SellTransaction::create([
            'user_id' => Auth::id(),
            'status' => SellStatus::Complete,
            'note' => $data['note'],
        ]);
        if ($createParent) {
            for ($i = 0; $i < $countItem; $i++) {
                $stock = MasterStock::where('id', $data['item_id'][$i])->first();
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
        $title = 'Sell Report';
        return view('sell-report.index', compact('data', 'title', 'req_item'));
    }
}
