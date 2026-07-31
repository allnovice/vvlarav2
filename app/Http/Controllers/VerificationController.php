<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\AssetVerification;

class VerificationController extends Controller
{
public function index(): Response
{
$totalAssets = Asset::count();

$verifiedAssets = Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '>=', Carbon::today())
    ->count();

$coverage = $totalAssets > 0
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

    return Inertia::render('Verification/Index', [
        'totalAssets' => $totalAssets,
        'totalAssets' => Asset::count(),
        'dueAssets' => Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '<=', Carbon::today())
    ->count(),
        'overdueAssets' => Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '<', Carbon::today())
    ->count(),
        'coverage' => $coverage,
        'monthlyVerifications' => $monthlyVerifications,
        'verificationAssets' => $verificationAssets,
        'neverVerified' => $neverVerified,
    ]);
}
}

