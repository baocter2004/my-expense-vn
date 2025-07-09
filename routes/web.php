<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;

// ========================== CLIENT ==============================
Route::name('client.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');

        // PROFILE 
        Route::get('/profile', [UserController::class, 'index'])->name('profile');
        Route::patch('/update-info', [UserController::class, 'update'])->name('update-info');
        Route::patch('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
        Route::patch('/avatar', [UserController::class, 'updateImage'])->name('update-avatar');

        // CATEGORIES
        Route::prefix('/categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::delete('/{id}/soft-delele',[CategoryController::class, 'delete'])->name('soft-delete');
                Route::patch('/update', [CategoryController::class, 'update'])->name('update');
            });
    });

// ========================== ADMIN ==============================

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    });

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
