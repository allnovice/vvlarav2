<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\AssetVerification;

class OperationsController extends Controller
{
    public function index(): Response
    {

$count = Asset::count();

$dueSoon = MaintenanceSchedule::whereBetween(
    'next_due_date',
    [today(), today()->addDays(30)]
)->count();

$overdue = MaintenanceSchedule::whereDate(
    'next_due_date',
    '<',
    today()
)->count();

$coveredAssets = MaintenanceSchedule::count();

$coverage = $count > 0
    ? round(($coveredAssets / $count) * 100)
    : 0;

$maintenanceAssets = Asset::leftJoin(
    'maintenance_schedules',
    'assets.id',
    '=',
    'maintenance_schedules.asset_id'
)
->select(
    'assets.id',
    'assets.property_number',
    'assets.type',
    'assets.brand',
    'assets.model',
    'maintenance_schedules.maintenance_date',
    'maintenance_schedules.next_due_date',
    'maintenance_schedules.frequency',
    'assets.department'
);
if (request()->filled('search')) {

    $maintenanceAssets->where(
        'assets.property_number',
        'like',
        '%' . request('search') . '%'
    );

}
$assets = $maintenanceAssets
    ->orderBy('assets.property_number')
    ->get();

$neverMaintained = $maintenanceAssets
    ->whereNull('maintenance_date')
    ->count();


$totalAssets = Asset::count();

$verifiedAssets = Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '>=', Carbon::today())
    ->count();

$verificationCoverage = $totalAssets > 0
    ? round(($verifiedAssets / $totalAssets) * 100)
    : 0;

$monthlyVerifications = AssetVerification::selectRaw(
        'MONTH(reviewed_at) as month, COUNT(*) as total'
    )
    ->whereNotNull('reviewed_at')
    ->where('reviewed_at', '>=', Carbon::now()->subMonths(12))
    ->groupBy('month')
    ->orderBy('month')
    ->get();

$verificationAssets = Asset::orderBy('property_number')
    ->get([
        'id',
        'property_number',
        'type',
        'brand',
        'model',
        'last_verified_at',
        'next_verification_due',
    ]);

$neverVerified = Asset::whereNull('last_verified_at')->count();

$dueAssets = Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '<=', Carbon::today())
    ->count();

$overdueAssets = Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '<', Carbon::today())
    ->count();

return Inertia::render('Operations/Index', [

    // Maintenance
    'maintenance' => [
        'totalAssets' => $count,
        'neverMaintained' => $neverMaintained,
        'dueSoon' => $dueSoon,
        'overdue' => $overdue,
        'coverage' => $coverage,
        'assets' => $assets,
    ],

    // Verification
    'verification' => [
        'totalAssets' => $totalAssets,
        'dueAssets' => $dueAssets,
        'overdueAssets' => $overdueAssets,
        'coverage' => $verificationCoverage,
        'monthlyVerifications' => $monthlyVerifications,
        'verificationAssets' => $verificationAssets,
        'neverVerified' => $neverVerified,
    ],

]);

    }
}
