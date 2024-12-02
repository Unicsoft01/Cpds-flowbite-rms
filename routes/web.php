<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HtmlMinifier;

Route::middleware([HtmlMinifier::class])->group(function () {

    Route::view('/', 'welcome');

    Route::middleware(['auth', 'verified'])->group(function () {

        Route::view('dashboard', 'dashboard')->name('dashboard');

        Route::view('profile', 'profile')->name('profile');
    });



    require __DIR__ . '/auth.php';
});