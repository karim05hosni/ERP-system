<?php

use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\products;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\users;
use App\Http\Controllers\Apis\Admin\InventoryController;
use App\Http\Controllers\dashboard_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;
use App\Models\Inventory;
use App\Models\OrderProduct;

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
Route::get(
    '/warehouses',
    function () {
        return view('Admin.warehouses.index');
    }
);
Route::get(
    '/warehouses/edit/{id}',
    function ($id) {
        $warehouse = App\Models\Warehouse::findOrFail($id);
        return view('Admin.warehouses.edit', compact('warehouse'));
    }
);
Route::get(
    '/warehouses/add',
    function () {
        return view('Admin.warehouses.add');
    }
);
Route::get(
    '/inventory',
    // [InventoryController::class, 'index']
    function () {
        return view('Admin.inventory.stock.index');
    }
);
Route::get(
    '/inventory/add',
    function () {
        return view('Admin.Inventory.stock.add');
    }
);
Route::get(
    '/inventory/edit/{id}',
    function ($id) {
        // Retrieve the inventory record with related data
        $inventory = Inventory::with(['product', 'warehouse'])->findOrFail($id);
        $quantitySold = OrderProduct::where('product_id', $inventory->product_id)
        ->where('warehouse_id', $inventory->warehouse_id)
        ->sum('quantity');
        // Prepare data to pass to the view
        $data = [
            'id' => $inventory->id,
            'product_name' => $inventory->product->name_en ?? 'N/A', // Assuming a relationship exists
            'warehouse_location' => $inventory->warehouse->location ?? 'N/A',
            'warehouse_district' => $inventory->warehouse->district ?? 'N/A',
            'quantity_inhand' => $inventory->quantity,
            'quantity_sold' => $quantitySold,
        ];

        // Return the edit view with data
        return view('Admin.inventory.stock.edit', compact('data'));
    }
);

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    // /dashboard
    Route::get('/', [dashboard_controller::class, 'index']);

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        // dashboard/products/
        Route::get('/', [products::class, 'all_products'])->name('all_products');
        Route::get('/create', [products::class, 'create'])->name('create');
        Route::post('/add', [products::class, 'add'])->name('add');
        Route::get('/edit/{id}', [products::class, 'edit'])->name('edit');
        // Route::get('/edit/{id}',[products::class, 'edit'])->name('Pedit');
        Route::put('/update/{id}', [products::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [products::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'Admins',  'as' => 'admins.'], function () {
        // dashboard/Admins/
        Route::get('/', [AdminsController::class, 'index'])->name('index');
        Route::get('/create', [AdminsController::class, 'create'])->name('create');
        Route::post('/add', [AdminsController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [AdminsController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdminsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminsController::class, 'destroy'])->name('delete');
    });
    Route::group(['prefix' => 'subcategories', 'as' => 'sub_categories.'], function () {
        // dashboard/SubCategories/
        Route::get('/', [SubCategoriesController::class, 'index'])->name('index');
        Route::get('/create', [SubCategoriesController::class, 'create'])->name('create');
        Route::post('/add', [SubCategoriesController::class, 'add'])->name('add');
        Route::get('/edit/{id}', [SubCategoriesController::class, 'edit'])->name('edit');
        // Route::get('/edit/{id}',[SubCategoriesController::class, 'edit'])->name('Pedit');
        Route::put('/update/{id}', [SubCategoriesController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SubCategoriesController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'accounting', 'as' => 'acc.'], function () {
        Route::get('/income_statement', [AccountingController::class, 'income_statement'])->name('income_statement');
    });
});;
// Route::get('dashboard', [dashboard_controller::class, 'index'])->name('index');
use Illuminate\Support\Facades\Auth;

Auth::routes(['prefix' => 'admin', 'name' => 'admin.', 'verify' => true]);

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

use App\Http\Controllers\Fee\presetsController;
use App\Http\Controllers\Fee\serviceController;

Route::group(['prefix' => 'fee', 'as' => 'fee.'], function () {
    Route::group(['prefix' => 'presets', 'as' => 'presets.'], function () {
        Route::get('/', [presetsController::class, 'index'])->name('index');
        Route::get('create', [presetsController::class, 'create'])->name('create');
        Route::post('/', [presetsController::class, 'store'])->name('store');
        Route::get('{id}/edit', [presetsController::class, 'edit'])->name('edit');
        Route::put('{id}', [presetsController::class, 'update'])->name('update');
        Route::delete('{id}', [presetsController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
        Route::get('/', [serviceController::class, 'index'])->name('index');    // List services
        Route::get('create', [serviceController::class, 'create'])->name('create');    // Show form to create a service
        Route::post('/', [ServiceController::class, 'store'])->name('store');    // Store the new service
        Route::get('{id}/edit', [ServiceController::class, 'edit'])->name('edit');    // Show form to edit a service
        Route::put('{id}', [ServiceController::class, 'update'])->name('update');    // Update the existing service
        Route::delete('{id}', [ServiceController::class, 'destroy'])->name('destroy');    // Delete the service
    });
    Route::group(['prefix' => 'thresholds', 'as' => 'thresholds.'], function () {
        Route::get('/', [serviceController::class, 'index'])->name('index');    // List services
        Route::get('create', [serviceController::class, 'create'])->name('create');    // Show form to create a service
        Route::post('/', [ServiceController::class, 'store'])->name('store');    // Store the new service
        Route::get('{id}/edit', [ServiceController::class, 'edit'])->name('edit');    // Show form to edit a service
        Route::put('{id}', [ServiceController::class, 'update'])->name('update');    // Update the existing service
        Route::delete('{id}', [ServiceController::class, 'destroy'])->name('destroy');    // Delete the service
    });
});
Route::group(['prefix' => '', 'as' => 'users.'], function () {
    // GET /users
    Route::get('/users', [usersController::class, 'index'])->name('index');

    // GET /users/create
    Route::get('/users/create', [usersController::class, 'create'])->name('create');

    // POST /users
    Route::post('/users', [usersController::class, 'store'])->name('store');

    // GET /users/{id}
    Route::get('/users/{id}', [usersController::class, 'show'])->name('show');

    // GET /users/{id}/edit
    Route::get('/users/{id}/edit', [usersController::class, 'edit'])->name('edit');

    // PATCH /users/{id}
    Route::patch('/users/{id}', [usersController::class, 'update'])->name('update');

    // DELETE /users/{id}
    Route::delete('/users/{id}', [usersController::class, 'destroy'])->name('destroy');
});
