<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterationController;
use App\Http\Controllers\RoutingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['auth:sanctum', 'tenant'])->group(function () {
    // Ecommerce app
    Route::prefix('ecommerce')->group(function () {
        Route::any('/', [RoutingController::class, 'forwardToEcommerce'])->where('any', '.*');
    });
    // ERP app
    Route::prefix('erp')->group(function () {
        Route::any('/', [RoutingController::class, 'forwardToErp'])->where('any', '.*');
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [RegisterationController::class, 'registerTenant'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

