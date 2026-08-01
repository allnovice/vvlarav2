<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Asset;
use App\Models\MaintenanceSchedule;

class MaintenanceController extends Controller
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
    'maintenance_schedules.frequency'
)
->orderBy('assets.property_number')
->get();

$neverMaintained = $maintenanceAssets
    ->whereNull('maintenance_date')
    ->count();

        return Inertia::render('Maintenance/Index', [
            'totalAssets' => $count,
            'neverMaintained' => $neverMaintained,
            'dueSoon' => $dueSoon,
            'overdue' => $overdue,
            'coverage' => $coverage,
            'maintenanceAssets' => $maintenanceAssets,
        ]);
    }
}
