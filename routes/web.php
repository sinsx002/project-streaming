<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AccountController;

// 👇 route login dan register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 👇 dashboard
Route::get('/dashboard/movies', [DashboardController::class, 'dashboard'])->middleware('web');
Route::get('/dashboard/movies/create', [MovieController::class, 'create']);
Route::post('/dashboard/movies', [MovieController::class, 'store']);
Route::get('/dashboard/movies/edit', [MovieController::class, 'edit']);
Route::delete('/dashboard/movies/{id}', [MovieController::class, 'destroy']);
Route::get('/dashboard/movies/{id}/edit', [MovieController::class, 'editFilm']);
Route::put('/dashboard/movies/{id}', [MovieController::class, 'update']);


Route::middleware(['auth.custom'])->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
});


