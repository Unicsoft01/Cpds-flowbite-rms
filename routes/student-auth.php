<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest:student')->group(function () {
    Volt::route('student/register', 'students.auth.register')
        ->name('students.register');

    Volt::route('student/login', 'students.auth.login')
        ->name('students.login');

    // Volt::route('forgot-password', 'pages.auth.forgot-password')
    // ->name('password.request');

    // Volt::route('reset-password/{token}', 'pages.auth.reset-password')
    // ->name('password.reset');
});

// Route::middleware('auth:student')->group(function () {
// Volt::route('verify-email', 'pages.auth.verify-email')
// ->name('verification.notice');

// Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
// ->middleware(['signed', 'throttle:6,1'])
// ->name('verification.verify');

// Volt::route('confirm-password', 'pages.auth.confirm-password')
// ->name('password.confirm');
// });