<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ClientAuthController;
use Illuminate\Support\Facades\Route;

// ========================== AUTH ===============================
Route::name('auth.')
    ->group(function () {
        Route::name('admin.')
            ->prefix('admin')
            ->group(function () {
                Route::get('/login', [AdminAuthController::class, 'showFormLogin'])->name('showFormLogin');
                Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
                Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
            });

        Route::name('client.')
            ->group(function () {
                Route::get('/register', [ClientAuthController::class, 'showFormRegister'])->name('showFormRegister');
                Route::post('/register', [ClientAuthController::class, 'register'])->name('register');
                Route::get('/login', [ClientAuthController::class, 'showFormLogin'])->name('showFormLogin');
                Route::post('/login', [ClientAuthController::class, 'login'])->name('login');
                Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');

                Route::get('/google', [ClientAuthController::class, 'redirectToGoogle'])->name('redirectToGoogle');
                Route::get('/google/callback', [ClientAuthController::class, 'handleGoogleCallback'])->name('handleGoogleCallback');

                Route::get('forgot-password', [ClientAuthController::class, 'showFormForgotPassword'])->name('showFormForgotPassword');
                Route::get('password/reset', [ClientAuthController::class, 'showFormResetPassword'])->name('password.reset');
            });
    });
