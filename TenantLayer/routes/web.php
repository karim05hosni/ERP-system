<?php

use App\Http\Controllers\RegisterationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [RegisterationController::class, 'registerTenant'])->name('register');
Route::get('/App-Portal', function(Request $request){
    return view('App_portal');
})->name('portal');