<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetHistoryController;

Route::get('/debug', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'url' => $request->fullUrl(),
        'scheme' => $request->getScheme(),
        'host' => $request->getHost(),
        'headers' => [
            'host' => $request->header('host'),
            'x-forwarded-proto' => $request->header('x-forwarded-proto'),
            'x-forwarded-host' => $request->header('x-forwarded-host'),
            'x-forwarded-for' => $request->header('x-forwarded-for'),
        ],
    ]);
});

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

Route::patch('/assets/{asset}/verify', [AssetController::class, 'verify'])
    ->middleware(['auth', 'admin'])
    ->name('assets.verify');

Route::post('/assets/{asset}/history', [AssetHistoryController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('assets.history.store');

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
