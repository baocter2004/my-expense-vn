<?php

use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\TransactionController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\WalletController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

// ========================== CLIENT ==============================

Route::name('client.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('/introduce', [HomeController::class, 'introduce'])->name('introduce');
        Route::get('/contact', [ContactController::class, 'showFormContact'])->name('showFormContact');
        Route::post('/contact', [ContactController::class, 'submit'])->name('submit');

        Route::middleware(['auth:user'])
            ->group(function () {
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
                        Route::delete('/{id}/soft-delele', [CategoryController::class, 'delete'])->name('soft-delete');
                        Route::patch('/update', [CategoryController::class, 'update'])->name('update');
                        Route::get('/create', [CategoryController::class, 'create'])->name('create');
                        Route::post('/create', [CategoryController::class, 'store'])->name('store');
                        Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
                        Route::post('/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
                    });

                // WALLETS
                Route::prefix('/wallets')
                    ->name('wallets.')
                    ->group(function () {
                        Route::get('/', [WalletController::class, 'index'])->name('index');
                        Route::delete('/{id}/soft-delele', [WalletController::class, 'delete'])->name('soft-delete');
                        Route::get('/create', [WalletController::class, 'create'])->name('create');
                        Route::post('/create', [WalletController::class, 'store'])->name('store');
                        Route::put('/{id}', [WalletController::class, 'update'])->name('update');
                        Route::get('/trash', [WalletController::class, 'trash'])->name('trash');
                        Route::post('/{id}/restore', [WalletController::class, 'restore'])->name('restore');
                    });

                // TRANSACTIONS
                Route::prefix('/transactions')
                    ->name('transactions.')
                    ->group(function () {
                        Route::get('/', [TransactionController::class, 'index'])->name('index');

                        Route::get('/create', [TransactionController::class, 'create'])->name('create');
                        Route::post('/', [TransactionController::class, 'store'])->name('store');

                        Route::post('/confirm', [TransactionController::class, 'confirm'])->name('confirm');
                        Route::post('{code}/confirm', [TransactionController::class, 'editConfirm'])->name('edit-confirm');

                        Route::get('/{code}/edit', [TransactionController::class, 'edit'])->name('edit');
                        Route::put('/{code}', [TransactionController::class, 'update'])->name('update');
                        Route::get('/{code}', [TransactionController::class, 'show'])->name('show');
                    });
            });
    });
