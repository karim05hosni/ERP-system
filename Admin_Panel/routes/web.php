<?php

use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\products;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\users;
use App\Http\Controllers\dashboard_controller;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'dashboard', 'middleware'=>'verified'], function () {
    // /dashboard
    Route::get('/', [dashboard_controller::class, 'index']);
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        // dashboard/products/
        Route::get('/', [products::class, 'all_products'])->name('all_products');
        Route::get('/create',[products::class, 'create'])->name('create');
        Route::post('/add',[products::class, 'add'])->name('add');
        Route::get('/edit/{id}',[products::class, 'edit'])->name('edit');
        // Route::get('/edit/{id}',[products::class, 'edit'])->name('Pedit');
        Route::put('/update/{id}',[products::class, 'update'])->name('update');
        Route::delete('/delete/{id}',[products::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'Admins',  'as' => 'admins.'], function () {
        // dashboard/Admins/
        Route::get('/',[AdminsController::class, 'index'])->name('index');
        Route::get('/create',[AdminsController::class, 'create'])->name('create');
        Route::post('/add',[AdminsController::class, 'add'])->name('add');
        Route::get('/edit/{id}',[AdminsController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',[AdminsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}',[AdminsController::class, 'destroy'])->name('delete');
    });
    Route::group(['prefix' => 'subcategories', 'as' => 'sub_categories.'], function () {
        // dashboard/SubCategories/
        Route::get('/', [SubCategoriesController::class, 'index'])->name('index');
        Route::get('/create',[SubCategoriesController::class, 'create'])->name('create');
        Route::post('/add',[SubCategoriesController::class, 'add'])->name('add');
        Route::get('/edit/{id}',[SubCategoriesController::class, 'edit'])->name('edit');
        // Route::get('/edit/{id}',[SubCategoriesController::class, 'edit'])->name('Pedit');
        Route::put('/update/{id}',[SubCategoriesController::class, 'update'])->name('update');
        Route::delete('/delete/{id}',[SubCategoriesController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'accounting', 'as' => 'acc.'], function(){
        Route::get('/income_statement', [AccountingController::class, 'income_statement'])->name('income_statement');
    });
});;
// Route::get('dashboard', [dashboard_controller::class, 'index'])->name('index');
use Illuminate\Support\Facades\Auth;
Auth::routes(['prefix' => 'admin', 'name' => 'admin.', 'verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// -----Email_Verification----
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

use Illuminate\Foundation\Auth\EmailVerificationRequest;
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');



use Illuminate\Http\Request;
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
