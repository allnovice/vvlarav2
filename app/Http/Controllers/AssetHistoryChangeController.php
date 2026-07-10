<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetHistoryChange;
use Inertia\Inertia;
use App\Models\AssetHistory;
use App\Services\AssetHistoryApprovalService;

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
public function approve(
    AssetHistoryChange $change,
    AssetHistoryApprovalService $service
)
{
$service->approve($change);

return redirect()
    ->route('asset-history-changes.index')
    ->with('success', 'History request approved.');
}
public function reject(
    AssetHistoryChange $change,
    AssetHistoryApprovalService $service
)
{
$service->reject($change);

return redirect()
    ->route('asset-history-changes.index')
    ->with('success', 'History request rejected.');
}



}
