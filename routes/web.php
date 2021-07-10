<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\StockMasterController;
use App\Http\Controllers\StockSupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('/');
Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('profile/{user_id}', [DashboardController::class, 'profile'])->name('profile');
Route::post('avatar/{user_id}', [DashboardController::class, 'avatar'])->name('avatar');
Route::post('account/{user_id}', [DashboardController::class, 'account'])->name('account');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Utility
Route::post('upload_avatar', [UtilityController::class, 'upload_avatar']);

// User Management
Route::prefix('super')->name('super.')->group(function () {
    // User
    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'user'])->name('index');
        Route::get('/toggle-status', [UserController::class, 'user_toggleStatus'])->name('toggleStatus');
        Route::post('/store', [UserController::class, 'user_store'])->name('store');
        Route::post('/update/{user_id?}', [UserController::class, 'user_update'])->name('update');
        Route::get('/destroy', [UserController::class, 'user_destroy'])->name('destroy');
    });
    // Role
    Route::prefix('/role')->name('role.')->group(function () {
        Route::get('/', [UserController::class, 'role'])->name('index');
        Route::post('/store', [UserController::class, 'role_store'])->name('store');
        Route::post('/update/{role_id?}', [UserController::class, 'role_update'])->name('update');
    });
});

// Item Management
Route::prefix('item')->name('item.')->group(function () {
    // Item Master
    Route::prefix('/')->group(function () {
        Route::get('/', [ItemMasterController::class, 'index'])->name('index');
        Route::post('/store', [ItemMasterController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ItemMasterController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ItemMasterController::class, 'update'])->name('update');
        Route::get('/destroy', [ItemMasterController::class, 'destroy'])->name('destroy');
    });
    // Item Category
    Route::prefix('/category')->name('category.')->group(function () {
        Route::get('/', [ItemCategoryController::class, 'index'])->name('index');
        Route::post('/store', [ItemCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ItemCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ItemCategoryController::class, 'update'])->name('update');
        Route::get('/destroy', [ItemCategoryController::class, 'destroy'])->name('destroy');
    });
});

// Stock Management
Route::prefix('stock')->name('stock.')->group(function () {
    // Stock Master
    Route::prefix('/master')->name('master.')->group(function () {
        Route::get('/', [StockMasterController::class, 'index'])->name('index');
        Route::post('/store', [StockMasterController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StockMasterController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StockMasterController::class, 'update'])->name('update');
        Route::get('/destroy', [StockMasterController::class, 'destroy'])->name('destroy');
    });
    // Stock Supplier
    Route::prefix('/supplier')->name('supplier.')->group(function () {
        Route::get('/', [StockSupplierController::class, 'index'])->name('index');
        Route::post('/store', [StockSupplierController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StockSupplierController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StockSupplierController::class, 'update'])->name('update');
        Route::get('/destroy', [StockSupplierController::class, 'destroy'])->name('destroy');
    });
});
