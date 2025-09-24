<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ClientAuthController;
use Illuminate\Support\Facades\Route;

// ========================== AUTH ===============================
Route::name('auth.')
    ->group(function () {
        // ================== ADMIN ==================
        Route::name('admin.')
            ->prefix('admin')
            ->group(function () {
                Route::middleware('guest:admin')->group(function () {
                    Route::get('/login', [AdminAuthController::class, 'showFormLogin'])->name('showFormLogin');
                    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
                    Route::get('/otp', [AdminAuthController::class, 'showOtpForm'])->name('otp.form');
                    Route::post('/otp', [AdminAuthController::class, 'verifyOtp'])->name('otp.verify');
                });

                Route::middleware('auth:admin')->group(function () {
                    Route::get('/forgot-password', [AdminAuthController::class, 'showFormForgotPassword'])->name('showFormForgotPassword');
                    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('reset-password');
                    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
                });
            });

        // ================== CLIENT ==================
        Route::name('client.')
            ->group(function () {
                Route::middleware('guest:user')->group(function () {
                    Route::get('/register', [ClientAuthController::class, 'showFormRegister'])->name('showFormRegister');
                    Route::post('/register', [ClientAuthController::class, 'register'])->name('register');
                    Route::get('/login', [ClientAuthController::class, 'showFormLogin'])->name('showFormLogin');
                    Route::post('/login', [ClientAuthController::class, 'login'])->name('login');

                    Route::get('/google', [ClientAuthController::class, 'redirectToGoogle'])->name('redirectToGoogle');
                    Route::get('/google/callback', [ClientAuthController::class, 'handleGoogleCallback'])->name('handleGoogleCallback');

                    Route::get('/forgot-password', [ClientAuthController::class, 'showFormForgotPassword'])->name('showFormForgotPassword');
                    Route::get('/password/reset', [ClientAuthController::class, 'showFormResetPassword'])->name('password.reset');
                });

                Route::middleware('auth:user')->group(function () {
                    Route::get('/email/verify', [ClientAuthController::class, 'verification'])
                        ->name('verification.notice');

                    Route::get('/email/verify/{id}/{hash}', [ClientAuthController::class, 'verify'])
                        ->middleware(['signed'])
                        ->name('verification.verify');

                    Route::post('/email/verification-notification', [ClientAuthController::class, 'resendVerification'])
                        ->middleware('throttle:6,1')
                        ->name('verification.resend');

                    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');
                });
            });
    });
