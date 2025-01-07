<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use GuzzleHttp\Middleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::post('/v1/checkout/sessions', [PaymentController::class, 'CheckoutSessionRequest'])->name('payments.create');
// });
// Route::post('/payments/create', [PaymentController::class, 'process'])->name('payments.create');
Route::get('/checkout-success', [PaymentController::class, 'success'])->name('checkout.success');
Route::get('/checkout-failure', [PaymentController::class, 'failure'])->name('checkout.failure');
