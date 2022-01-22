<?php

namespace App\Http\Controllers;

use App\Casts\UserLevel;
use App\Traits\NewsAPI_Request;
use Illuminate\Http\Request;

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

    public function dashboard(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        if (!isset($data['category'])){
            $data['category'] = 'business';
        }
        if (!isset($data['page'])){
            $data['page'] = 1;
        }
        $category = $data['category'];
        $page = $data['page'];
        $headlines = $this->getHeadlines($category, $page);
        return view('dashboard',compact('headlines','category'));
    }

    private function getHeadlines($category, $page)
    {
        return $this->newsRequest('GET', 'v2/top-headlines', [
            'country' => 'id',
            'category' => $category,
            'page'=> $page,
            'pageSize' => 9
        ]);
    }
}
