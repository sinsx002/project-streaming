<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AccountController;

// === Auth routes ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === Movie Dashboard ===
Route::get('/dashboard/movies', [DashboardController::class, 'dashboard'])->middleware('web');
Route::get('/dashboard/movies/create', [MovieController::class, 'create']);
Route::post('/dashboard/movies', [MovieController::class, 'store']);
Route::get('/dashboard/movies/edit', [MovieController::class, 'edit']);
Route::delete('/dashboard/movies/{id}', [MovieController::class, 'destroy']);
Route::get('/dashboard/movies/{id}/edit', [MovieController::class, 'editFilm']);
Route::put('/dashboard/movies/{id}', [MovieController::class, 'update']);
Route::post('/review/store', [moviecontroller::class, 'storeReview'])->name('review.store');
// === Account Routes (user) ===
Route::middleware(['check.user'])->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.profile');
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::post('/account/delete', [AccountController::class, 'destroy'])->name('account.destroy');
});

// === Admin User Management ===
Route::get('/admin/users', [AccountController::class, 'adminIndex'])->name('admin.users');
Route::delete('/admin/users/{id_user}', [AccountController::class, 'adminDestroy'])->name('admin.users.destroy');

Route::get('/dashboard/movies/search-suggestions', [MovieController::class, 'searchSuggestions']);

Route::get('/stream/{id}', [MovieController::class, 'stream'])->name('movie.stream');

Route::post('/reviews/store', [MovieController::class, 'storeReview'])->name('reviews.store');
