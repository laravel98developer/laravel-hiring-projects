<?php

use App\Http\Controllers\dashboard\ProductController;

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('product',[ProductController::class,'index'])->name('product.index');
});
