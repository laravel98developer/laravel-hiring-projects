<?php

use App\Http\Controllers\dashboard\OrderController;

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('order/{product_id}',[OrderController::class,'index'])->name('order.index');
    Route::post('order/create',[OrderController::class,'create'])->name('order.create');
});
