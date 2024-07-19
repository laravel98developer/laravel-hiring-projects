<?php

use App\Http\Controllers\Delivery\OrderController;
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

Route::get('orders', [OrderController::class, 'index']);
Route::post('orders/{id}/accept', [OrderController::class, 'accept']);
Route::post('orders/{id}/delivering', [OrderController::class, 'delivering']);
Route::post('orders/{id}/delivered', [OrderController::class, 'delivered']);

