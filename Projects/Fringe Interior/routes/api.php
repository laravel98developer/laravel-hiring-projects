<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "/auth", "middleware" => "api"], function () {
    Route::post("/register", [AuthController::class, "register"])->name("api.register");
    Route::post("/login", [AuthController::class, "login"])->name("api.login");
    Route::delete("/logout", [AuthController::class, "logout"])->name("api.logout")->middleware("auth:sanctum");
});

Route::group(["prefix" => "/products", "middleware" => ["api", "auth:sanctum"]], function () {
    Route::get(null, [ProductController::class, "index"])->name("api.products_index");
    Route::post(null, [ProductController::class, "store"])->name("api.products_store");
    Route::get("/{id}", [ProductController::class, "show"])->name("api.products_show");
    Route::put("/{id}", [ProductController::class, "update"])->name("api.products_update");
    Route::delete("{id}", [ProductController::class, "delete"])->name("api.products_delete");
});

Route::group(["prefix" => "/orders", "middleware" => ["api", "auth:sanctum"]], function () {
    Route::get(null, [OrderController::class, "index"])->name("api.orders_index");
    Route::post(null, [OrderController::class, "store"])->name("api.orders_store");
    Route::get("/{id}", [OrderController::class, "show"])->name("api.orders_show");
    Route::put("/{id}", [OrderController::class, "update"])->name("api.orders_update");
    Route::delete("/{id}", [OrderController::class, "delete"])->name("api.orders_delete");
});
