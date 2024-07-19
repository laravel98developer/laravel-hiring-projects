<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TransactionController;

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

Route::middleware('ChangeFaNumbersToEn')->post('/transaction', [TransactionController::class, 'store'])->name('doTransaction');
Route::get('/lastTransactions', [TransactionController::class, 'showLastTransactions'])->name('lastTransactions');
