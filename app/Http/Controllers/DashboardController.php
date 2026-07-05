<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
public function index()
{
    return Inertia::render('Dashboard', [
    'totalAssets' => Asset::count(),
    'activeAssets' => Asset::where('status', 'Active')->count(),
    'underRepairAssets' => Asset::where('status', 'Under Repair')->count(),
    'borrowedAssets' => Asset::where('status', 'Borrowed')->count(),
    'archivedAssets' => Asset::where('status', 'Archived')->count(),
    'totalUsers' => User::count(),
]);


}
}
