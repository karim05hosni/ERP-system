<?php

use App\Http\Controllers\Apis\Admin\InventoryController;
use App\Http\Controllers\Apis\Admin\ProductsController;
use App\Http\Controllers\Apis\Auth\EmailVerificationController;
use App\Http\Controllers\Apis\Auth\LoginController;
use App\Http\Controllers\Apis\Auth\RegisterController;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Admin\products;
use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\users;
use App\Http\Controllers\Apis\Admin\AdminsController;
use App\Http\Controllers\Apis\Admin\WarehouserController;
use App\Http\Controllers\dashboard_controller;
use App\Models\Inventory;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'verify'], function () {

Route::group(['prefix' => 'products'], function () {
    // dashboard/products/
    Route::get('/', [ProductsController::class, 'all_products'])->name('products.fetch');
    Route::post('/store',[ProductsController::class, 'store']);
    Route::put('/update/{id}',[ProductsController::class, 'update']);
    Route::delete('/delete/{id}',[ProductsController::class, 'destroy']);
});
Route::group(['prefix' => 'users'], function () {
    // dashboard/users/
    Route::get('/',[users::class, 'all_users']);
    Route::get('/create',[users::class, 'create']);
    Route::get('/edit/{id}',[users::class, 'edit']);
    Route::get('/delete/{id}',[users::class, 'delete']);
});
Route::group(['prefix' => 'warehouse'], function () {
    Route::get('/', [WarehouserController::class, 'index']);
    Route::post('/add-warehouse', [WarehouserController::class, 'store']);
    Route::post('/edit-warehouse/{id}', [WarehouserController::class, 'update']);
    Route::get('/show-warehouse', [WarehouserController::class, 'show']);
    Route::delete('/destroy-warehouse/{id}', [WarehouserController::class, 'destroy']);
});
Route::group(['prefix' => 'inventory'], function () {
    Route::get('/', [InventoryController::class, 'index']);
    Route::post('/add-inventory', [InventoryController::class, 'store']);
    Route::post('/update-inventory/{id}', [InventoryController::class, 'update']);
    Route::delete('/delete-inventory/{id}', [InventoryController::class, 'destroy']);
    Route::get('/show-inventory', [InventoryController::class, 'show']);
});
Route::group(['prefix' => 'subcategories'], function () {
    // dashboard/SubCategories/
    Route::get('/', [SubCategoriesController::class, 'index']);
    Route::get('/create',[SubCategoriesController::class, 'create']);
    Route::post('/add',[SubCategoriesController::class, 'add']);
    Route::get('/edit/{id}',[SubCategoriesController::class, 'edit']);
    // Route::get('/edit/{id}',[SubCategoriesController::class, 'edit'])->name('Pedit');
    Route::put('/update/{id}',[SubCategoriesController::class, 'update']);
    Route::delete('/delete/{id}',[SubCategoriesController::class, 'delete']);
});
});
Route::group(['prefix'=>'user'], function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', [LoginController::class, 'login']);
    Route::delete('/logout', [LoginController::class, 'logout']);
    Route::delete('/logout-all', [LoginController::class, 'logout_all']);
    Route::group(['middleware'=>'auth:sanctum'], function (){
        Route::post('/sendcode', [EmailVerificationController::class, 'sendCode']);
        Route::post('/verifycode', [EmailVerificationController::class, 'verifyCode']);
    });
});
Route::group(['prefix'=>'admins'], function(){
    Route::get('/', [AdminsController::class, 'index']);
    Route::post('/create-admin', [AdminsController::class, 'store']);
});



