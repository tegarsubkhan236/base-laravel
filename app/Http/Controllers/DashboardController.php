<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Models\Stock;
use App\Traits\NewsAPI_Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use NewsAPI_Request;
    public function __construct()
    {
        $this->middleware($this->allowedAccess(
            [
                UserLevel::SUPER_ADMIN,
                UserLevel::ADMIN,
                UserLevel::STOCK_USER,
            ]
        ));
    }

    public function dashboard()
    {
//        $response = $this->newsRequest('GET', 'v2/top-headlines', [
//            'country' => 'id',
//            'category' => 'business'
//        ]);
//        return $response;

        return view('dashboard');
    }
}
