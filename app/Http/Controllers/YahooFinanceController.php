<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Traits\Brandfetch_Request;
use App\Traits\YH_Finance_Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class YahooFinanceController extends Controller
{
    use YH_Finance_Request;
    use Brandfetch_Request;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Yahoo.yahoo');
    }

    public function search(Request $request)
    {
        $request->validate([
            'symbol' => 'required'
        ]);
        $data = $request->all();
        $symbol = $data['symbol'] . ".JK";
        $profile = $this->getProfile($symbol);
        if (!isset($profile['assetProfile'])) {
            return redirect()->back()->with('error', 'Stock Not Found');
        }
        $statistic = $this->getStatistic($symbol);
        if (!isset($statistic['defaultKeyStatistics'])) {
            return redirect()->back()->with('error', 'Stock Not Found');
        }
        if (!isset($statistic['defaultKeyStatistics']['netIncomeToCommon'])){
            return redirect()->back()->with('error', 'Stock Not Found');
        }
        if (isset($profile['assetProfile']['website'])){
            $web_split = explode("//", $profile['assetProfile']['website']);
            $brandRequest = $this->brandRequest($web_split[1]);
        }else{
            $brandRequest = $this->brandRequest($profile['quoteType']['longName']);
        }
        $logo = collect($brandRequest);
        return view('Yahoo.yahoo', [
            'symbol' => strtoupper($data['symbol']),
            'profile' => $profile,
            'statistic' => $statistic,
            'logo' => $logo
        ]);
    }

    public function list_sector()
    {
        $data = DB::table('stocks')
            ->select('sector', DB::raw('count(subSector) as total'))
            ->groupBy('sector')
            ->get();
        return view('Yahoo.list-sector',[
            'data' => $data
        ]);
    }

    public function stock_compare()
    {
        return view('Yahoo.stock-compare');
    }
    public function list_subSector($sector)
    {
        $data = DB::table('stocks')
            ->where(['sector'=>$sector])
            ->select('subSector', DB::raw('count(*) as total'))
            ->groupBy('subSector')
            ->get();
        return view('Yahoo.list-subSector',[
            'data' => $data,
            'sector' => $sector,
        ]);
    }

    public function list_stock($sector,$subSector = null)
    {
        $data = Stock::where([
            'sector'=> $sector,
            'subSector' => $subSector
        ])->get();
        return view('Yahoo.list-stock',[
            'data' => $data,
            'sector' => $sector,
            'subSector' => $subSector,
        ]);
    }

//    public function list_sector($sector)
//    {
//        $data = Stock::where('sector',$sector)->get();
//        return view('Yahoo.list-stock',[
//            'data' => $data,
//            'sector' => $sector,
//        ]);
//    }

    public function stock_detail($sector, $subSector = null, $id)
    {
        $data = Stock::where(['id'=>$id])->first();
        $totalData = Stock::where(['sector'=>$sector,'subSector'=>$subSector])->get();
        $totalPER = 0;
        foreach ($totalData as $x){
            $totalPER += $x->actualPrice/($x->netIncome/$x->outstandingShare);
        }
        $avgPER_Industry = $totalPER / $totalData->count();
        $intrinsicValue = ($data->netIncome / $data->outstandingShare) * $avgPER_Industry;
        return view('Yahoo.sector-detail',[
            'data' => $data,
            'sector' => $sector,
            'avgPER_Industry' => $avgPER_Industry,
            'intrinsicValue' => $intrinsicValue,
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'sector' => 'required',
            'subSector' => 'required',
            'summary' => 'required',
            'avatar' => 'nullable',
            'netIncome' => 'required',
            'profitMargin' => 'required',
            'operationMargin' => 'required',
            'returnOnAsset' => 'required',
            'returnOnEquity' => 'required',
            'marketCap' => 'required',
            'outstandingShare' => 'required',
            'actualPrice' => 'required',
        ]);
        $data = $request->all();
        unset($data['_token']);
        $stock = Stock::updateOrCreate(
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'sector' => $data['sector'],
                'subSector' => $data['subSector'],
            ],
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'sector' => $data['sector'],
                'subSector' => $data['subSector'],
                'summary' => $data['summary'],
                'avatar' => $data['avatar'],
                'netIncome' => $data['netIncome'],
                'profitMargin' => $data['profitMargin'],
                'operationMargin' => $data['operationMargin'],
                'returnOnAsset' => $data['returnOnAsset'],
                'returnOnEquity' => $data['returnOnEquity'],
                'marketCap' => $data['marketCap'],
                'outstandingShare' => $data['outstandingShare'],
                'actualPrice' => $data['actualPrice'],
                'created_by' => Auth::id()
            ]
        );
        if ($stock) {
            return redirect()->route('yahoo')->with('success', 'Stock Has Been Stored');
        }
        return redirect()->route('yahoo')->withErrors('error', 'Nothing');
    }

    public function update($id)
    {
        $data = Stock::find($id);
        if ($data){
            $symbol = $data['code'] . ".JK";
            $profile = $this->getProfile($symbol);
            $statistic = $this->getStatistic($symbol);
            $web_split = explode("//", $profile['assetProfile']['website']);
            $brandRequest = $this->brandRequest($web_split[1]);
            $logo = collect($brandRequest);
            $action = $data->update([
                'name' => $profile['quoteType']['shortName'],
                'sector' => $profile['assetProfile']['sector'],
                'summary' => strtok($profile['assetProfile']['longBusinessSummary'], '.'),
                'avatar' => $logo['logos'][0]['formats'][0]['src'],
                'netIncome' => $statistic['defaultKeyStatistics']['netIncomeToCommon']['raw'],
                'profitMargin' => $statistic['financialData']['profitMargins']['raw'],
                'operationMargin' => $statistic['financialData']['operatingMargins']['raw'],
                'returnOnAsset' => $statistic['financialData']['returnOnAssets']['raw'],
                'returnOnEquity' => $statistic['financialData']['returnOnEquity']['raw'],
                'marketCap' => $statistic['summaryDetail']['marketCap']['raw'],
                'outstandingShare' => $statistic['defaultKeyStatistics']['sharesOutstanding']['raw'],
                'actualPrice' => $statistic['price']['regularMarketPrice']['raw'],
                'created_by' => Auth::id()
            ]);
            if ($action) {
                return redirect()->back()->with('success', 'Stock Has Been Updated');
            }
        }
    }

    private function getProfile($symbol): Collection
    {
        $response = $this->makeRequest('GET', 'stock/v2/get-profile', [
            'symbol' => $symbol
        ]);
        return collect($response);
    }

    private function getStatistic($symbol): Collection
    {
        $response = $this->makeRequest('GET', 'stock/v3/get-statistics', [
            'symbol' => $symbol
        ]);
        return collect($response);
    }
}
