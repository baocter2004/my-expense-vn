<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ========================== ADMIN ==============================

Route::prefix('admin')
    ->middleware(['auth:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::name('profile.')
            ->prefix('profile')
            ->group(function () {
                Route::get('/', [ProfileController::class, 'show'])->name('show');
                Route::get('/change-pasword', [ProfileController::class, 'showFormChangePassword'])->name('change-password');
                Route::post('/change-pasword', [ProfileController::class, 'changePassword'])->name('change-password');
                Route::put('/update-profile',[ProfileController::class,'update'])->name('update-profile');
            });

        Route::name('users.')
            ->prefix('users')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/{id}', [UserController::class, 'show'])->name('show');
            });
    });
