<?php

use App\Http\Controllers\Frontend\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'create'])
    ->middleware(['guest'])
    ->name('public.register');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware(['guest']);

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('public.login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');
