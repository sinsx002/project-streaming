<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;

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

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard/movies/search-suggestions', [MovieController::class, 'searchSuggestions']);