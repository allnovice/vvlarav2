<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/assets', [AssetController::class, 'index'])
        ->name('assets');
    Route::get('/assets/{asset}', [AssetController::class, 'show'])
        ->name('assets.show');
    Route::post('/assets', [AssetController::class, 'store'])
        ->name('assets.store');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');
    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])
        ->name('assets.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
