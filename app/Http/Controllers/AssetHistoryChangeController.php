<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetHistoryChange;
use Inertia\Inertia;
use App\Models\AssetHistory;

class AssetHistoryChangeController extends Controller
{

public function index(Request $request)
{
    $status = $request->get(
        'status',
        AssetHistoryChange::STATUS_PENDING
    );

    $query = AssetHistoryChange::with([
        'asset',
        'user',
    ]);

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $changes = $query
        ->latest()
        ->get();

    return Inertia::render('AssetHistoryChanges/Index', [
        'changes' => $changes,
        'status' => $status,
    ]);
}

public function show(AssetHistoryChange $change)
{
    return Inertia::render('AssetHistoryChanges/Show', [
        'change' => $change->load([
            'asset',
            'user',
	    'approver',
        ]),
    ]);
}
public function approve(AssetHistoryChange $change)
{

    if ($change->status !== AssetHistoryChange::STATUS_PENDING) {
        return redirect()
            ->route('asset-history-changes.index')
            ->with('error', 'This request has already been processed.');
    }

    AssetHistory::create([
        'asset_id' => $change->asset_id,
        'type' => $change->type,
        'title' => $change->title,
        'description' => $change->description,
        'performed_by' => $change->performed_by,
        'performed_at' => $change->performed_at,
        'remarks' => $change->remarks,
    ]);

    $change->update([
        'status' => AssetHistoryChange::STATUS_APPROVED,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);

    return redirect()
        ->route('asset-history-changes.index')
        ->with('success', 'History request approved.');
}
public function reject(AssetHistoryChange $change)
{

if ($change->status !== AssetHistoryChange::STATUS_PENDING) {
    return redirect()
        ->route('asset-history-changes.index')
        ->with('error', 'This request has already been processed.');
}

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
