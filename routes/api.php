<?php
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('sendResetLinkEmail');
Route::post('/password/reset', [AuthController::class, 'handleResetPassword'])->name('password.update');