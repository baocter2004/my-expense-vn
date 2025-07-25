<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// ========================== ADMIN ==============================

Route::prefix('admin')
    ->middleware(['auth:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    });
