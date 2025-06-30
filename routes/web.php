<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard/movies', [DashboardController::class, 'dashboard'])->middleware('web');

Route::get('/dashboard/movies/create', [MovieController::class, 'create']);

Route::post('/dashboard/movies', [MovieController::class, 'store']);

Route::get('/dashboard/movies/edit', [MovieController::class, 'edit']);

Route::delete('/dashboard/movies/{id}', [MovieController::class, 'destroy']);

Route::get('/dashboard/movies/{id}/edit', [MovieController::class, 'editFilm']);

Route::put('/dashboard/movies/{id}', [MovieController::class, 'update']);