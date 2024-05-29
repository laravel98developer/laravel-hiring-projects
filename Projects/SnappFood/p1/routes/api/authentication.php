<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('signin', [UserController::class, 'signin']);

Route::get('signout', [UserController::class, 'signout']);
