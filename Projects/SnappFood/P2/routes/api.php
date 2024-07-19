<?php

use App\Http\Controllers\Agent;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('admins')->name('admins.')->group(function () {
    Route::apiResource('trips', Admin\TripController::class)->only('index', 'store', 'update');
    Route::apiResource('agents', Admin\AgentController::class)->only('index', 'store');
    Route::apiResource('vendors', Admin\VendorController::class)->only('index', 'store');
});

Route::prefix('agents')->name('agents.')->group(function () {
    Route::post('delay-reports/assign', [Agent\DelayReportController::class, 'assign'])
        ->name('delay-reports.assign');
    Route::get('delay-reports/analytics', [Agent\DelayReportController::class, 'analytics'])
        ->name('delay-reports.analytics');
});

Route::prefix('customers')->name('customers.')->group(function () {
    Route::post('delay-reports', [Customer\DelayReportController::class, 'store'])
        ->name('delay-reports.store');

    Route::apiResource('orders', Customer\OrderController::class)
        ->only('index', 'store');
});
