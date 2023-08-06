<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CookieController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProductTagController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

require __DIR__ . '/admin-auth.php';

Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['auth', 'backend']], function () {

    Route::post('/sidebar-collapse', [CookieController::class, 'sidebarCollapse'])->name('sidebar.collapse');

    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('admin.dashboard');

    Route::group(['prefix' => '/blog', 'as' => 'blog.'], function () {
        Route::resource('posts', PostController::class);
        Route::resource('categories', PostCategoryController::class);
    });

    Route::group(['prefix' => '/manage-media'], function () {
        Route::resource('media', MediaController::class);
    });

    Route::group(['prefix' => '/manage-user'], function () {
        Route::resource('user', UserController::class);
        Route::resource('role', RoleController::class);
    });

    Route::group(['prefix' => '/manage-store'], function () {
        Route::resource('products', ProductController::class);
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('product-tags', ProductTagController::class);
        Route::resource('product-attributes', ProductAttributeController::class);
        Route::resource('product-colors', ProductColorController::class);
        Route::resource('product-sizes', ProductSizeController::class);
        Route::resource('product-brands', ProductBrandController::class);
    });
});
