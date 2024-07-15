<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\TodoController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\EmailVerificationController;
use Illuminate\Support\Facades\Route;


Route::get('/user', [UserController::class, 'show'])->middleware("auth:sanctum")->name("user.show");

Route::get("/email/verify/{id}/{hash}", [EmailVerificationController::class, "verify"])->name("verification.verify")
    ->middleware(["signed", "throttle:3,1"]);
Route::post("/email/resend", [EmailVerificationController::class, "resend"])->middleware("auth:sanctum");


Route::group(["prefix" => "/auth"], function () {
    Route::post("/register", [AuthController::class, "register"])->name("auth.register");
    Route::post("/login", [AuthController::class, "login"])->name("auth.login");
    Route::delete("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum")->name('auth.logout');
});

Route::group(["prefix" => "/categories", "middleware" => ["auth:sanctum", "verified"]], function () {
    Route::get("/", [CategoryController::class, "index"])->name("category.index");
});

Route::group(["prefix" => "/todos", "middleware" => ["auth:sanctum", "verified"]], function () {
    Route::get("/", [TodoController::class, "index"])->name("todo.index");
    Route::post("/", [TodoController::class, "store"])->name("todo.store");
    Route::get("/{id}", [TodoController::class, "show"])->name("todo.show");
    Route::put("/{id}", [TodoController::class, "update"])->name("todo.update");
    Route::delete("/{id}", [TodoController::class, "destroy"])->name("todo.destroy");
});
