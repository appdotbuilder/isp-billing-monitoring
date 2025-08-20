<?php

use App\Http\Controllers\IspDashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // ISP Management Routes
    Route::controller(IspDashboardController::class)->group(function () {
        Route::get('/isp', 'index')->name('isp.dashboard');
        Route::post('/isp', 'store')->name('isp.monitoring');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
