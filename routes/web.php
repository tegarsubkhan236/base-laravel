<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
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
    return view('landing.home');
})->name('/');
Route::get('login',[AuthController::class,'login_page'])->name('login');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::any('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['gateway']], function() {
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('profile',[UserController::class,'profile'])->name('profile');

    Route::name('user-setting.')->prefix('user-setting/')->group(function (){
        Route::resource('user',UserController::class);
        Route::resource('role',RoleController::class);
        Route::resource('permission',PermissionController::class);
    });

    Route::resource('test',TestController::class);
});
