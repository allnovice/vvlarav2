<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Asset;

class ReportController extends Controller
{
public function index(Request $request)
{

$query = $this->buildAssetQuery($request);

$assets = $query->paginate(10)->withQueryString();

$departments = Asset::query()
    ->whereNotNull('department')
    ->where('department', '!=', '')
    ->distinct()
    ->orderBy('department')
    ->pluck('department');

$locations = Asset::query()
    ->whereNotNull('location')
    ->where('location', '!=', '')
    ->distinct()
    ->orderBy('location')
    ->pluck('location');

$types = Asset::query()
    ->whereNotNull('type')
    ->where('type', '!=', '')
    ->distinct()
    ->orderBy('type')
    ->pluck('type');

$statuses = Asset::query()
    ->whereNotNull('status')
    ->where('status', '!=', '')
    ->distinct()
    ->orderBy('status')
    ->pluck('status');

return Inertia::render('Reports/Index', [
    'assets' => $assets,
    'departments' => $departments,
    'locations' => $locations,
    'types' => $types,
    'statuses' => $statuses,
    'filters' => [
        'department' => $request->department,
        'location' => $request->location,
        'type' => $request->type,
        'status' => $request->status,
        'search' => $request->search,
    ],
]);
}
public function exportCsv(Request $request)
{
    $query = $this->buildAssetQuery($request);

    $filename = 'assets-report-' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

return response()->stream(function () use ($query) {

    $handle = fopen('php://output', 'w');

    fputcsv($handle, [
        'Property Number',
        'Type',
        'Description',
        'Status',
        'Department',
        'Location',
        'Assigned To',
    ]);

    foreach ($query->get() as $asset) {
        fputcsv($handle, [
            $asset->property_number,
            $asset->type,
            $asset->description,
            $asset->status,
            $asset->department,
            $asset->location,
            $asset->assigned_to,
        ]);
    }

    fclose($handle);

}, 200, $headers);
}
private function buildAssetQuery(Request $request)
{
    $query = Asset::query()->orderBy('property_number');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('property_number', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('serial_number', 'like', "%{$search}%")
              ->orWhere('assigned_to', 'like', "%{$search}%");
        });
    }

    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    if ($request->filled('location')) {
        $query->where('location', $request->location);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    return $query;
}
}

