<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GiftCodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'cache'], function () {

    Route::get('flush', function () {
        Cache::flush();
    });

});

Route::group(['prefix' => 'user', 'middleware' => 'authentication'], function () {

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/', [WalletController::class, 'balance']);
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [TransactionController::class, 'allByPhone']);
    });

    Route::group(['prefix' => 'gift/code'], function () {
        Route::post('/', [GiftCodeController::class, 'add'])->middleware('lottery');
    });

});

Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'gift/code'], function () {
        Route::post('/', [GiftCodeController::class, 'create']);
    });

    Route::get('transactions/{code}/success', [UserController::class, 'successTransactions']);

});
