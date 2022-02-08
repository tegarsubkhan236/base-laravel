<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('login');
})->name('/');
Route::get('login',[AuthController::class,'login_page'])->name('login');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('profile',[UserController::class,'index'])->name('profile');
