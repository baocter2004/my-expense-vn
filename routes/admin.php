<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ========================== ADMIN ==============================

Route::prefix('admin')
    ->middleware(['auth:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::name('users.')
            ->prefix('users')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
            });
    });
