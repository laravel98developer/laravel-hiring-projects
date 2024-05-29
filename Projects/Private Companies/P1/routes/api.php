<?php

namespace AliSalehi\Task\route;

use AliSalehi\Task\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'task-middleware'])->prefix('api/v1/')->group(function () {
    Route::apiResource('task', TaskController::class);
});