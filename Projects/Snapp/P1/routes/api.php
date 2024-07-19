<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\TransactionController;
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

Route::prefix('v1')->group(function () {
    // auth
    Route::post('/login', [AuthController::class, 'login']); // just for testing purposes

    Route::middleware(['auth:sanctum'])->group(function () {
        // transaction
        Route::prefix('transaction')->controller(TransactionController::class)->group(function () {
            Route::post('/{bank_account_card:unique_id}', 'create')->can('create', 'bank_account_card');
            Route::get('/top-users', 'topUsers');
        });
    });
});
