<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class, 'index'])->name('login');
Route::post('register', [RegisterController::class, 'index']);

Route::resource('providers', ProviderController::class);
Route::resource('products', ProductController::class);
Route::resource('product_reviews', ProductReviewController::class);
Route::resource('reviews', ReviewController::class);
Route::resource('baskets', BasketController::class);
