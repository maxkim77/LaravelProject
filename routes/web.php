<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Auth\HomeController; // Import HomeController

// Home page route
Route::get('/', [HomeController::class, '__invoke'])->name('home'); // Corrected route definition

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
Route::resource('articles', ArticleController::class);
Route::resource('comments', CommentController::class)->only(['store', 'destroy']);
Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile')->where('username', '[A-Za-z_]+$');
Route::post('follow', [FollowController::class, 'follow'])->name('follow');
Route::delete('follow', [FollowController::class, 'destroy'])->name('unfollow');
