<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssetController extends Controller
{
    public function index()
    {
        return Inertia::render('Assets', [
            'assets' => Asset::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
    // Asset Information
    'property_number' => ['required', 'string', 'max:255'],
    'type' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'status' => ['required', 'string', 'max:50'],

    // Specifications
    'brand' => ['nullable', 'string', 'max:255'],
    'model' => ['nullable', 'string', 'max:255'],
    'serial_number' => ['nullable', 'string', 'max:255'],
    'manufacturer' => ['nullable', 'string', 'max:255'],

    // Assignment
    'assigned_to' => ['nullable', 'string', 'max:255'],
    'department' => ['nullable', 'string', 'max:255'],
    'location' => ['nullable', 'string', 'max:255'],

    // Acquisition
    'acquisition_date' => ['nullable', 'date'],
    'acquisition_cost' => ['nullable', 'numeric'],
    'supplier' => ['nullable', 'string', 'max:255'],
    'warranty_expiry' => ['nullable', 'date'],
]);

        Asset::create($validated);

        return redirect()->route('assets');
    }
    public function update(Request $request, Asset $asset)
    {
        
$validated = $request->validate([
    // Asset Information
    'property_number' => ['required', 'string', 'max:255'],
    'type' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'status' => ['required', 'string', 'max:50'],

    // Specifications
    'brand' => ['nullable', 'string', 'max:255'],
    'model' => ['nullable', 'string', 'max:255'],
    'serial_number' => ['nullable', 'string', 'max:255'],
    'manufacturer' => ['nullable', 'string', 'max:255'],

    // Assignment
    'assigned_to' => ['nullable', 'string', 'max:255'],
    'department' => ['nullable', 'string', 'max:255'],
    'location' => ['nullable', 'string', 'max:255'],

    // Acquisition
    'acquisition_date' => ['nullable', 'date'],
    'acquisition_cost' => ['nullable', 'numeric'],
    'supplier' => ['nullable', 'string', 'max:255'],
    'warranty_expiry' => ['nullable', 'date'],
]);
        $asset->update($validated);

        return redirect()->route('assets');
    }
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets');
    }
    public function show(Asset $asset)
    {
    return Inertia::render('Assets/Show', [
        'asset' => $asset,
        ]);
    }
    public function edit(Asset $asset)
    {
    return Inertia::render('Assets/Edit', [
        'asset' => $asset,
    ]);
    }
}
