<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AssetPhotoChange;
use App\Models\AssetHistoryChange;
use App\Models\AssetHistory;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
public function index()
{
$totalAssets = Asset::count();

$assetStatuses = Asset::selectRaw('status, COUNT(*) as count')
    ->groupBy('status')
    ->orderBy('status')
    ->get();
    
    $totalUsers = User::count();

    $maintainedAssets = Asset::whereHas('history', function ($query) {



$query->where('title', 'Preventive Maintenance');
})->count();

$unmaintainedAssets = $totalAssets - $maintainedAssets;

$maintenanceCoverage = $totalAssets > 0
    ? round(($maintainedAssets / $totalAssets) * 100)
    : 0;


$pendingChanges = Asset::whereHas('pendingChange')->count();
$pendingVerifications = Asset::whereHas('pendingVerification')->count();
$pendingPhotoChanges = AssetPhotoChange::where(
    'status',
    AssetPhotoChange::STATUS_PENDING
)->count();
$pendingHistoryChanges = AssetHistoryChange::where(
    'status',
    AssetHistoryChange::STATUS_PENDING
)->count();
$recentActivities = AssetHistory::with('asset')
    ->latest('performed_at')
    ->take(10)
    ->get();


$assets = Asset::leftJoin(
    'maintenance_schedules',
    'assets.id',
    '=',
    'maintenance_schedules.asset_id'
)
->select(
    'assets.id',
    'assets.property_number',
    'assets.type',
    'assets.department',
    'maintenance_schedules.maintenance_date',
    'maintenance_schedules.next_due_date'
)
->orderBy('assets.property_number')
->get();

$releases = Http::get(
    'https://api.github.com/repos/allnovice/vvlarav2/releases'
)->json();

    return Inertia::render('Dashboard/Index', [
        'totalAssets' => $totalAssets,
        'totalUsers' => $totalUsers,
        'assetStatuses' => $assetStatuses,

'maintainedAssets' => $maintainedAssets,
'unmaintainedAssets' => $unmaintainedAssets,
'maintenanceCoverage' => $maintenanceCoverage,



'pendingChanges' => $pendingChanges,
'pendingVerifications' => $pendingVerifications,
'pendingPhotoChanges' => $pendingPhotoChanges,
'pendingHistoryChanges' => $pendingHistoryChanges,
'recentActivities' => $recentActivities,
'assets' => $assets,
'releases' => $releases,
    ]);
}



}
