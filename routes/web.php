<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::patch('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/assets', [AssetController::class, 'store'])
        ->name('assets.store');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');
    Route::get('/assets/{asset}/qr', [AssetController::class, 'qr'])
        ->name('assets.qr');
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
});

Route::get('/assets', [AssetController::class, 'index'])
    ->name('assets');

Route::get('/assets/{asset}', [AssetController::class, 'show'])
    ->name('assets.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
