<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ShopController;

Route::group([], function () {

    require __DIR__ . '/public-auth.php';

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('shop', ShopController::class)->only(['index']);

    Route::resource('blog', BlogController::class)->only('index', 'show');

    Route::resource('product', ProductController::class)->only('show');

});


