<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\AssetHistory;

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

    \App\Models\AssetHistoryChange::create([
    'user_id' => auth()->id(),
    'asset_id' => $asset->id,
    'type' => $validated['type'],
    'title' => $validated['title'],
    'description' => $validated['description'],
    'performed_by' => auth()->user()->name,
    'performed_at' => $validated['performed_at'],
    'remarks' => $validated['remarks'],
]);

    return redirect()
        ->route('assets.show', $asset)
        ->with('success', 'History request submitted for approval.');
}
public function show(AssetHistoryChange $change)
{
    return Inertia::render('AssetHistoryChanges/Show', [
        'change' => $change->load([
            'asset',
            'user',
        ]),
    ]);
}
public function approve(AssetHistoryChange $change)
{
    AssetHistory::create([
    'asset_id' => $change->asset_id,
    'type' => $change->type,
    'title' => $change->title,
    'description' => $change->description,
    'performed_by' => $change->performed_by,
    'performed_at' => $change->performed_at,
    'remarks' => $change->remarks,
]);
return redirect()
    ->route('asset-history-changes.index')
    ->with('success', 'History request approved.');

}
public function reject(AssetHistoryChange $change)
{
    $change->update([
        'status' => AssetHistoryChange::STATUS_REJECTED,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);

    return redirect()
        ->route('asset-history-changes.index')
        ->with('success', 'History request rejected.');
}




}
