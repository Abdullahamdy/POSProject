<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\WelcomeController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\OrderController as DashboardOrderController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
            Route::get('/',[WelcomeController::class,'index'] )->name('welcome');
            Route::resource('orders', DashboardOrderController::class);
            Route::resource('users',UserController::class);
            Route::resource('categories',CategoryController::class);
            Route::resource('products',ProductController::class);
            Route::resource('clients',ClientController::class);
            Route::resource('clients.orders',OrderController::class);
        });
    });





