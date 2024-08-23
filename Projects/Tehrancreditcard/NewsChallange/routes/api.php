<?php

use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('store/newsapi' , [NewsController::class , "storeNewsFromNewsApi"]);
Route::get('store/guardian' , [NewsController::class , "storeNewsFromGuardian"]);

