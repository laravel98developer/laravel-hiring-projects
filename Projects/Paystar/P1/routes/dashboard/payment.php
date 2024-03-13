<?php

use App\Http\Controllers\payment\PaymentController;

Route::prefix('payment')->group(function () {
    Route::post('callback',[PaymentController::class,'index'])->name('payment-callback');
});
