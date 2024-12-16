<?php

use App\Http\Controllers\API\OrderController;
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

Route::get('orders/{status}', [OrderController::class, 'getOrders']);
Route::get('orders', [OrderController::class, 'getOrdersB']);

Route::post('orders/failed-track', [OrderController::class, 'failedTrack'])->name('api.orders.failedTrack');
