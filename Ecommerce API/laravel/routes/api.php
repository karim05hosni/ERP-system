<?php

use App\Http\Controllers\API\Auth\EmailVerificationController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
        Route::group([], function(){
            Route::prefix('order')->group(function () {
                Route::post('place-order', [OrderController::class, 'placeOrder']);
                Route::post('cancel-order', [OrderController::class, 'cancelOrder']);
                Route::get('order-info', [OrderController::class, 'orderInfo']);
            });
            Route::prefix('cart')->group(function () {
                Route::get('add-to-cart', [CartController::class, 'store']);
                Route::get('show-cart', [CartController::class, 'show']);
                Route::delete('remove-from-cart', [CartController::class, 'destroy']);
            });
        });
        Route::prefix('auth')->group(function () {
            Route::post('register', [RegisterController::class, 'store']);
            Route::post('login', [LoginController::class, 'login']);
            Route::prefix('email-verification')->group(function () {
                Route::post('send-code',[EmailVerificationController::class,'sendcode']);
                Route::post('verification',[EmailVerificationController::class,'verifyCode']);
            });
        });
});
