<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetController extends Controller
{
    public function index()
    {
        return Inertia::render('Assets', [
            'assets' => Asset::latest()->paginate(10),
        ]);
    }

public function qr(Asset $asset)
{
    $url = route('assets.show', $asset);

    $qr = (string) QrCode::format('svg')
    ->size(250)
    ->generate($url);

    return Inertia::render('Assets/PrintQr', [
        'asset' => $asset,
        'qr' => $qr,
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
            'photo' => ['nullable', 'image', 'max:2048'],

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

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('assets', 'public');
        }

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
            'photo' => ['nullable', 'image', 'max:2048'],

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

        if ($request->hasFile('photo')) {

            if ($asset->photo_path) {
                Storage::disk('public')->delete($asset->photo_path);
            }

            $validated['photo_path'] = $request->file('photo')->store('assets', 'public');
        }


        $asset->update($validated);

        return redirect()->route('assets.show', $asset);
    }

    public function destroy(Asset $asset)
    {
        if ($asset->photo_path) {
            Storage::disk('public')->delete($asset->photo_path);
        }

        $asset->delete();

        return redirect()->route('assets');
    }

    public function show(Asset $asset)
    {
        return Inertia::render('Assets/Show', [
            'asset' => $asset,
        ]);
    }

public function verify(Asset $asset)
{
    $asset->update([
        'verified_at' => now(),
        'verified_by' => auth()->id(),
    ]);

    return redirect()
        ->route('assets.show', $asset)
        ->with('success', 'Asset verified successfully.');
}






}
