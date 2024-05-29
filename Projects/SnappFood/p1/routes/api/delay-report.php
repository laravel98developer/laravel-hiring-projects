<?php

use App\Http\Controllers\DelayReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->post('/{order}/delay-report', [DelayReportController::class, 'store'])->name('submit-delay-report');

Route::get('assign-delay-report', [DelayReportController::class, 'assignDelayReport'])->name('assign-delay-report');

Route::get('{vendor}/delay-report', [DelayReportController::class, 'vendorDelayReport'])->name('delay-report');
