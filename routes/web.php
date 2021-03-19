<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('login', [AuthController::class, 'login_page'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register_page'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::any('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile/{user_id}', [DashboardController::class, 'profile'])->name('profile');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('super')->name('super.')->group(function (){
    Route::get('user', [UserController::class, 'user'])->name('user');
    Route::get('role', [UserController::class, 'role'])->name('role');
    Route::get('role-user', [UserController::class, 'role_user'])->name('role-user');
});
