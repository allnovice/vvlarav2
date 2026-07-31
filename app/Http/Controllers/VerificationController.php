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

$monthlyVerifications = AssetVerification::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    ->whereYear('created_at', now()->year)
    ->groupBy('month')
    ->orderBy('month')
    ->get();

$dueSoonAssets = Asset::whereNotNull('next_verification_due')
    ->whereDate('next_verification_due', '>=', Carbon::today())
    ->orderBy('next_verification_due')
    ->limit(10)
    ->get([
        'id',
        'property_number',
        'type',
        'next_verification_due',
    ]);

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
        'dueSoonAssets' => $dueSoonAssets,
    ]);
}
}

