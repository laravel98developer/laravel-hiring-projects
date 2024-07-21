<?php

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tag\TagController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Homepage
Route::get('/', [ArticleController::class, 'home'])->name('home');

// A list of posts under this category
Route::get('/category/{category}', [CategoryController::class, 'category'])->name('category');

// A list of posts with this tag
Route::get('/tag/{tag}', [TagController::class, 'tag'])->name('tag');

// Display a single post
Route::get('/articles/{articleId}', [ArticleController::class, 'show'])->name('show');

// A list of posts based on search query
//Route::post('/search', [PostController::class, 'search'])->name('search');


// Dashboard routes
Route::middleware('auth')->prefix('dashboard')->group(function () {

    // Dashboard homepage
    Route::get('/', [ArticleController::class, 'index'])->name('dashboard');

    // Dashboard category resource
    Route::resource('categories', CategoryController::class);

    // Dashboard tag resource
    Route::resource('tags', TagController::class);

    // Dashboard post resource
    Route::resource('articles', ArticleController::class);

})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
