<?php

use App\Http\Controllers\checkoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'payments'], function(){
    Route::get('/index',[checkoutController::class,'create'])->name('checkout.index');
    Route::post('/checkout', [checkoutController::class,'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', function ($orderId) {
        return "Payment was successful for order ID: $orderId";
    })->name('checkout.success');
    
    Route::get('/checkout/cancel/{order}', function ($orderId) {
        return "Payment was canceled for order ID: $orderId";
    })->name('checkout.cancel');
});
