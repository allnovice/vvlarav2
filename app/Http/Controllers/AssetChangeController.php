<?php

namespace App\Http\Controllers;

use App\Models\AssetChange;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use App\Services\AssetApprovalService;
use Illuminate\Http\Request;

class AssetChangeController extends Controller
{

public function index(Request $request)
{
    $status = $request->get('status', AssetChange::STATUS_PENDING);

    $query = AssetChange::with('user');

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $changes = $query
        ->latest()
        ->get();

    return Inertia::render('AssetChanges/Index', [
        'changes' => $changes,
        'status' => $status,
    ]);
}

public function approve(
    AssetChange $change,
    AssetApprovalService $approvalService
)
{

    if ($change->status !== 'pending') {
        return redirect()
            ->route('asset-changes.index')
            ->with('error', 'This request has already been processed.');
    }

    DB::transaction(function () use ($change, $approvalService) {
        $approvalService->approve($change);
    });

    return redirect()
        ->route('asset-changes.index')
        ->with('success', 'Request approved successfully.');
}


public function show(AssetChange $change)
{

    return Inertia::render('AssetChanges/Show', [
        'change' => $change->load([
            'user',
            'approver',
        ]),
    ]);

}
public function reject(
    AssetChange $change,
    AssetApprovalService $service
)
{
    $service->reject($change);

    return redirect()
        ->route('asset-changes.index')
        ->with('success', 'Request rejected.');
}




}
