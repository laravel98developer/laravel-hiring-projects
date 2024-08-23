<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [NewsController::class , 'showNews']);
Route::get('/{externalId}' , [NewsController::class , 'newsPage']);

