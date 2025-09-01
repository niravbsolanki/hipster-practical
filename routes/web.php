<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\Auth\LoginController as CustomerAuthLoginController;
use App\Http\Controllers\Customer\Auth\RegisterController as CustomerAuthRegisterController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('customer.login');
});


//Admin Routes
Route::prefix('admin')->group(function(){

    Route::middleware('admin.guest')->group(function(){
        Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'loginPost'])->name('admin.login');
        Route::get('/register', [RegisterController::class, 'register'])->name('admin.register');
        Route::post('/register', [RegisterController::class, 'registerPost'])->name('admin.register');
    });

    Route::middleware('admin.auth')->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [DashboardController::class, 'logout'])->name('admin.logout');
        Route::resource('product', ProductController::class);
        Route::post('product/import', [ProductController::class,'importProduct'])->name('products.import');
        Route::get('order-list', [OrderController::class,'index'])->name('order.list');
        Route::post('order-status', [OrderController::class,'orderStatus'])->name('order.status');

    });
});

//Customer Routes
Route::prefix('customer')->group(function(){

    Route::middleware('customer.guest')->group(function(){
        Route::get('/login', [CustomerAuthLoginController::class, 'login'])->name('customer.login');
        Route::post('/login', [CustomerAuthLoginController::class, 'loginPost'])->name('customer.login');
        Route::get('/register', [CustomerAuthRegisterController::class, 'register'])->name('customer.register');
        Route::post('/register', [CustomerAuthRegisterController::class, 'registerPost'])->name('customer.register');

    });

    Route::middleware('customer.auth')->group(function(){
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
        Route::post('/logout', [CustomerDashboardController::class, 'logout'])->name('customer.logout');
        Route::get('customer/order/{id}', [CustomerDashboardController::class, 'placeOreder'])->name('customer.place.order');
        Route::get('search', [CustomerDashboardController::class, 'searchProduct'])->name('customer.search');
        Route::get('my-order', [CustomerDashboardController::class, 'myOrder'])->name('customer.order');
    });
});


