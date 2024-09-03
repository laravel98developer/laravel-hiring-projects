<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('activities', ActivityController::class);
Route::apiResource('bookings', BookingController::class);
