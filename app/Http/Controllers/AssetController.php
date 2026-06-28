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
            'assets' => Asset::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_number' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => 'required|string|max:50',
        ]);

        Asset::create($validated);

        return redirect()->route('assets');
    }
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'property_number' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $asset->update($validated);

        return redirect()->route('assets');
    }
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets');
}
}
