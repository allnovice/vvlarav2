<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetHistoryController extends Controller
{


public function store(Request $request, Asset $asset)
{

    $validated = $request->validate([
        'type' => ['required', 'in:maintenance,repair'],
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'performed_at' => ['required', 'date'],
        'remarks' => ['nullable', 'string'],
    ]);

    \App\Models\AssetHistory::create([
    'asset_id' => $asset->id,
    'type' => $validated['type'],
    'title' => $validated['title'],
    'description' => $validated['description'],
    'performed_by' => auth()->id(),
    'performed_at' => $validated['performed_at'],
    'remarks' => $validated['remarks'],
]);

    return redirect()
        ->route('assets.show', $asset)
        ->with('success', 'History entry added successfully.');
}



}
