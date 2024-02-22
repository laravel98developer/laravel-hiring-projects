<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\PostController as PostV1;
use App\Http\Controllers\API\V2\PostController as PostV2;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::fallback(function (Request $request) {
    $url = url()->current();
    $version = explode('/', explode('/api/', $url)[1])[0];
    $versionNumber = trim($version, 'v');

    if($versionNumber > 1) {
        $previousVersion = --$versionNumber;
        $newUrl = str_replace("/api/$version", "/api/v$previousVersion", $url);
        return redirect($newUrl, 301);
    } else {
        abort(404);
    }
});

Route::prefix('/v1')->name('v1.')->group(function () {
    Route::prefix('/posts')->name('post.')->group(function () {
        Route::get('/', [PostV1::class,'index'])->name('index');
        Route::get('{post}/show', [PostV1::class,'show'])->name('show');
    });
});

Route::prefix('/v2')->name('v2.')->group(function () {
    Route::prefix('/posts')->name('post.')->group(function () {
        Route::get('/', [PostV2::class,'index'])->name('index');
    });
});
