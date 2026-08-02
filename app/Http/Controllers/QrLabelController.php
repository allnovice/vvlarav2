<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Asset;

class QrLabelController extends Controller
{
public function index(Request $request)
{
    $query = Asset::query();

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

    $sort = $request->input('sort', 'property_number');
    $direction = $request->input('direction', 'asc');

    $query->orderBy($sort, $direction);

    if ($request->filled('status') && $request->status !== 'All') {
        $query->where('status', $request->status);
    }

    return Inertia::render('QrLabels/Index', [
        'assets' => $query->paginate(10)->withQueryString(),
        'search' => $request->search,
    ]);
}
public function print(Request $request)
{
    $ids = explode(',', $request->ids);

$assets = Asset::whereIn('id', $ids)
    ->orderBy('property_number')
    ->get();

$assets->transform(function ($asset) {

    $asset->qr = (string) QrCode::format('svg')
        ->size(180)
        ->generate(route('assets.qr', $asset));

    return $asset;
});

return Inertia::render('QrLabels/Print', [
    'assets' => $assets,
]);
}
}
