<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\YahooFinanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login_page'])->name('/');
Route::get('login', [AuthController::class, 'login_page'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::any('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('home', [DashboardController::class, 'dashboard'])->name('home');

Route::name('yahoo')->prefix('yahoo/')->group(function (){
    // Search
    Route::get('search', [YahooFinanceController::class, 'index']);
    Route::post('search', [YahooFinanceController::class, 'search'])->name('.search');
    // List
    Route::get('list-sector', [YahooFinanceController::class, 'list_sector'])->name('.list.sector');
    Route::get('list-subSector/{sector}', [YahooFinanceController::class, 'list_subSector'])->name('.list.subSector');
    Route::get('list-stock/{sector}/{subSector?}', [YahooFinanceController::class, 'list_stock'])->name('.list.stock');
    Route::get('stock-detail/{sector}/{subSector?}/{id}', [YahooFinanceController::class, 'stock_detail'])->name('.stock.detail');
    // Compare
    Route::get('stock-compare', [YahooFinanceController::class, 'stock_compare'])->name('.stock.compare');
    // Action
    Route::post('save', [YahooFinanceController::class, 'save'])->name('.save');
    Route::put('update/{id}', [YahooFinanceController::class, 'update'])->name('.update');
    Route::delete('delete', [YahooFinanceController::class, 'delete'])->name('.delete');
});
