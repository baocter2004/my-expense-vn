<?php

use App\Http\Controllers\API\AiController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Client\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('sendResetLinkEmail');
Route::post('/password/reset', [AuthController::class, 'handleResetPassword'])->name('password.update');

Route::name('client.')
    ->prefix('client')
    ->group(function () {
        Route::patch('/{id}/update-status', [CategoryController::class, 'updateStatus'])->name('update-status');
    });

Route::name('ai.')
    ->prefix('ai')
    ->group(function () {
        Route::post('/query', [AiController::class, 'query']);
    });
