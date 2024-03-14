<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Home page route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route with 'auth' and 'verified' middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile management routes with 'auth' middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

// Articles management routes
// Route::middleware('auth')->group(function () {
//     Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
//     Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
//     Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
//     Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
//     Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
//     Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
//     Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

Route::resource('articles', ArticleController::class);
Route::resource('comments', CommentController::class)->only(['store', 'destroy']);
Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile')-> where('username', '[A-Za-z_]+');
