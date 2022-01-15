<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
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
        $this->middleware($this->allowedAccess(
            [
                UserLevel::SUPER_ADMIN,
                UserLevel::ADMIN,
                UserLevel::STOCK_USER,
            ]
        ));
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
        $statistic = $this->getStatistic($symbol);
        if (!isset($profile['quoteType'])){
            return redirect()->back()->with('error','Your access to this service has been limited');
        }
        if (!isset($statistic['defaultKeyStatistics']) || !isset($statistic['defaultKeyStatistics']['netIncomeToCommon']) || !isset($profile['assetProfile'])) {
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
            ->select('sector', DB::raw('count(sub_sector) as total'))
            ->groupBy('sector')
            ->orderBy('sector','asc')
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
            ->select('sub_sector', DB::raw('count(*) as total'))
            ->groupBy('sub_sector')
            ->orderBy('sub_sector','asc')
            ->get();
        return view('Yahoo.list-subSector',[
            'data' => $data,
            'sector' => $sector,
        ]);
    }

    public function list_stock($sector,$sub_sector = null)
    {
        $data = Stock::where([
            'sector'=> $sector,
            'sub_sector' => $sub_sector
        ])->get();
        return view('Yahoo.list-stock',[
            'data' => $data,
            'sector' => $sector,
            'sub_sector' => $sub_sector,
        ]);
    }

    public function stock_detail($sector, $sub_sector = null, $id)
    {
        $data = Stock::where(['id'=>$id])->first();
        $totalData = Stock::where(['sector'=>$sector,'sub_sector'=>$sub_sector])->get();
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
            'sub_sector' => 'required',
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
            ],
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'sector' => $data['sector'],
                'sub_sector' => $data['sub_sector'],
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
