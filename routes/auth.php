<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('login', [AuthenticatedSessionController::class, 'create'])
     ->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Registration routes
Route::get('register', [RegisteredUserController::class, 'create'])
     ->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

// Logout route
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
     ->name('logout');
