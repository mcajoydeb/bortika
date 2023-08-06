<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Admin\CookieController;

if (Cookie::get('locale')) {
    App::setLocale(Cookie::get('locale'));
}

Route::get('/locale/{locale}', [CookieController::class, 'setLocale'])->name('locale.set');

require __DIR__ . '/admin-routes.php';

require __DIR__ . '/public-routes.php';



