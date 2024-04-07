<?php

use App\Http\Controllers\DeliveryRequestController;
use App\Http\Controllers\UserController;
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
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function() {
    Route::prefix("delivery-request")->group(function() {
        Route::get('all', [DeliveryRequestController::class, 'all_deliverers_list']);
        Route::put('{delivery_request_id}/cancel', [DeliveryRequestController::class, 'cancel']);
        Route::put('{delivery_request_id}/accept', [DeliveryRequestController::class, 'accept']);
        Route::put('{delivery_request_id}/received', [DeliveryRequestController::class, 'received']);
        Route::put('{delivery_request_id}/delivered', [DeliveryRequestController::class, 'delivered']);
    });
    Route::resource('delivery-request', DeliveryRequestController::class);
    Route::get('deliverers/delivery-request', [DeliveryRequestController::class, 'deliverers_list']);
    Route::put('users/setwebhook/{id?}', [UserController::class, 'setWebhook']);
});
Route::get('users/get-token', [UserController::class, 'getToken']);