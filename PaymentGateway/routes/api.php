<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\checkoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/payments/create', [checkoutController::class, 'process'])->name('payments.create');
Route::get('/payments/success/{order_id}', [checkoutController::class, 'success'])->name('success');
Route::get('/payments/status/{order_id}', [checkoutController::class, 'status'])->name('payments.status');