<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetChangeController;
use App\Http\Controllers\AssetHistoryChangeController;
use App\Http\Controllers\AssetVerificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AssetPhotoController;
use App\Http\Controllers\AssetPhotoChangeController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceExecutionController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');

/*--------------approval-routes-ithead-PSO-admin--------------*/
Route::middleware(['auth', 'admin', 'approve.users'])->group(function () {

    Route::post('/users/{user}/approve', [UserController::class, 'approve'])
        ->name('users.approve');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');


});
/*--------------dashboard--------------*/
Route::get('/', [DashboardController::class, 'index'])
    ->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

/*--------------user admin controlled--------------*/
Route::middleware(['auth', 'admin'])->group(function () {

Route::post('/asset-photo-changes/{change}/approve', [AssetPhotoChangeController::class, 'approve'])
    ->name('asset-photo-changes.approve');

Route::post('/asset-photo-changes/{change}/reject', [AssetPhotoChangeController::class, 'reject'])
    ->name('asset-photo-changes.reject');

    Route::post('/asset-changes/{change}/approve', [AssetChangeController::class, 'approve'])
        ->name('asset-changes.approve');
    Route::post('/asset-changes/{change}/reject', [AssetChangeController::class, 'reject'])
        ->name('asset-changes.reject');

    Route::post('/asset-history-changes/{change}/approve', [AssetHistoryChangeController::class, 'approve'])
        ->name('asset-history-changes.approve');
    Route::post('/asset-history-changes/{change}/reject', [AssetHistoryChangeController::class, 'reject'])
        ->name('asset-history-changes.reject');
    Route::post('/asset-verifications/{assetVerification}/approve', [AssetVerificationController::class, 'approve'])
        ->name('asset-verifications.approve');
    Route::post('/asset-verifications/{assetVerification}/reject', [AssetVerificationController::class, 'reject'])
        ->name('asset-verifications.reject');

Route::post('/assets/{asset}/link-parent', [AssetController::class, 'linkParent'])
    ->name('assets.link-parent');
});


Route::middleware(['auth', 'verified'])->group(function () {
/*--------------------qr--------------*/
Route::get('/assets/qr/{asset}', [AssetController::class, 'showQr'])
    ->name('assets.qr');
Route::get('/assets/{asset}/qr', [AssetController::class, 'qr'])
    ->name('assets.print-qr');
/*--------------------verify--------------*/
    Route::patch('/assets/{asset}/verify', [AssetController::class, 'verify'])
        ->name('assets.verify');
/*--------------------store--------------*/
    Route::post('/assets', [AssetController::class, 'store'])
        ->name('assets.store');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');
    Route::post('/assets/{asset}/history', [AssetHistoryController::class, 'store'])
        ->name('assets.history.store');
    Route::post('/assets/{asset}/verify', [AssetVerificationController::class, 'store'])
        ->name('asset-verifications.store');

    Route::post('/assets/{asset}/photos', [AssetPhotoController::class, 'store'])
        ->name('assets.photos.store');

    Route::get('/asset-photo-changes', [AssetPhotoChangeController::class, 'index'])
        ->name('asset-photo-changes.index');

    Route::get('/asset-photo-changes/{change}', [AssetPhotoChangeController::class, 'show'])
        ->name('asset-photo-changes.show');

Route::post(
    '/maintenance/{asset}/perform',
    [MaintenanceExecutionController::class, 'perform']
)->name('maintenance.perform');

Route::get('/maintenance', [MaintenanceController::class, 'index'])
    ->name('maintenance.index');

Route::get('/verification', [VerificationController::class, 'index'])
    ->name('verification.index');


Route::post('/assets/{asset}/maintenance-schedule', [MaintenanceScheduleController::class, 'store'])
    ->name('maintenance-schedule.store');

Route::put('/assets/{asset}/maintenance-schedule', [MaintenanceScheduleController::class, 'update'])
    ->name('maintenance-schedule.update');

Route::delete('/assets/{asset}/maintenance-schedule', [MaintenanceScheduleController::class, 'destroy'])
    ->name('maintenance-schedule.destroy');

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');
Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])
    ->name('reports.export.csv');


Route::get('/assets/search', [AssetController::class, 'search'])
    ->name('assets.search');

Route::post(
    '/assets/photos/{photo}/caption',
    [AssetPhotoController::class, 'requestCaptionUpdate']
)->name('assets.photos.caption');
Route::post(
    '/assets/photos/{photo}/delete',
    [AssetPhotoController::class, 'requestDelete']
)->name('assets.photos.delete');
/*--------------------show--------------*/
    Route::get('/asset-changes/{change}', [AssetChangeController::class, 'show'])
        ->name('asset-changes.show');
    Route::get('/asset-history-changes/{change}', [AssetHistoryChangeController::class, 'show'])
        ->name('asset-history-changes.show');
    Route::get('/asset-verifications/{assetVerification}', [AssetVerificationController::class, 'show'])
        ->name('asset-verifications.show');
    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');
/*--------------------index--------------*/
    Route::get('/asset-verifications', [AssetVerificationController::class, 'index'])
        ->name('asset-verifications.index');
    Route::get('/asset-history-changes', [AssetHistoryChangeController::class, 'index'])
        ->name('asset-history-changes.index');
    Route::get('/asset-changes', [AssetChangeController::class, 'index'])
        ->name('asset-changes.index');
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
/*--------------------profile--------------*/
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*--------------public--------------*/
Route::get('/assets', [AssetController::class, 'index'])
    ->name('assets');
Route::get('/assets/{asset}', [AssetController::class, 'show'])
    ->name('assets.show');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity-logs.index');

require __DIR__.'/auth.php';
