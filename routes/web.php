<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DummyController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
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
Route::get('dummy',[DummyController::class,'permission'])->name('dummy');
Route::get('login',[AuthController::class,'login_page'])->name('login');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('profile',[UserController::class,'profile'])->name('profile');

Route::name('user-setting.')->prefix('user-setting/')->group(function (){
    Route::get('user',[UserController::class,'index'])->name('user');
    Route::get('role',[RoleController::class,'index'])->name('role');
    Route::get('permission',[PermissionController::class,'index'])->name('permission');
});
