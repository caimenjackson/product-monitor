<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LogController;


Route::get('/check-time', function() {
    return response()->json(['current_time' => now()->format('Y-m-d H:i:s')]);
});

Route::get('/products/refresh', [ProductController::class, 'refresh'])->name('special.products.refresh');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index']); 
    Route::post('/products/{product}/cook', [ProductController::class, 'cook']);
    Route::post('/products/{product}/waste', [ProductController::class, 'waste']);
    Route::post('/products/{product}/sell', [ProductController::class, 'sell']);
    Route::get('/export-pdf', [ProductController::class, 'exportPdf'])->name('export.pdf');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';