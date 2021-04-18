<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view('auth.login');
})->name('/');
Route::get('login', function (){
    return view('auth.login');
})->name('login');
Route::get('register', function (){
    return view('auth.register');
})->name('register');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('profile/{user_id}', [DashboardController::class, 'profile'])->name('profile');
Route::post('avatar/{user_id}', [DashboardController::class, 'avatar'])->name('avatar');
Route::post('account/{user_id}', [DashboardController::class, 'account'])->name('account');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Super Admin
Route::prefix('super')->name('super.')->group(function (){
    // User
    Route::prefix('/user')->name('user.')->group(function (){
        Route::get('/', [UserController::class, 'user'])->name('index');
        Route::get('/toggle-status', [UserController::class, 'user_toggleStatus'])->name('toggleStatus');
        Route::post('/store', [UserController::class, 'user_store'])->name('store');
        Route::post('/update/{user_id?}', [UserController::class, 'user_update'])->name('update');
        Route::get('/destroy', [UserController::class, 'user_destroy'])->name('destroy');
    });
    // Role
    Route::prefix('/role')->name('role.')->group(function (){
        Route::get('/', [UserController::class, 'role'])->name('index');
        Route::post('/store', [UserController::class, 'role_store'])->name('store');
        Route::post('/update/{role_id?}', [UserController::class, 'role_update'])->name('update');
    });
});

// Utility
Route::post('upload',[UtilityController::class, 'upload']);
