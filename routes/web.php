<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\WorkingWithOrdersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Artisan;

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
    if(Auth::check()) {
        return redirect('/orders');
    } else {
        return view('auth.login');
    }
})->name('enter');
Route::group(['middleware' => 'auth'], function() {
    /* logout from app */
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/orders/all', [OrdersController::class, 'getAllOrders']);
    Route::get('/services', [ServicesController::class, 'index']);
    Route::post('/change_status', [OrdersController::class, 'changeStatus']);
    Route::post('/add_order', [WorkingWithOrdersController::class, 'addOrder']);
    Route::get('/search_client', [WorkingWithOrdersController::class, 'searchLogin']);
    Route::get('/open_orders', [OrdersController::class, 'getOpenOrders']);
    Route::get('/order/edit/{id}', [WorkingWithOrdersController::class, 'openOrder']);
    Route::get('/order/story/{id}', [WorkingWithOrdersController::class, 'getStory']);
    Route::post('/update_order', [WorkingWithOrdersController::class, 'updateOrder']);
    Route::get('/orders/massDelete/{students}', [WorkingWithOrdersController::class, 'massDelete']);
    Route::get('/orders/selectAll', [WorkingWithOrdersController::class, 'selectAll']);

    Route::get('/orders/export/{orders}', [OrdersController::class, 'export']);
});

Route::group(['middleware' => 'is_admin', 'prefix' => 'dashboard'], function() {
    /* logout from app */
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/total', [AdminController::class, 'getTotalData']);
    Route::get('/st', function () {
       Artisan::call('storage:link');

       return Artisan::output();
    });;
});

Auth::routes();


