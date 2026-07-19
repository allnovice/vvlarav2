<?php

namespace App\Http\Controllers;

use App\Models\AssetPhotoChange;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AssetPhotoApprovalService;

class AssetPhotoChangeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', AssetPhotoChange::STATUS_PENDING);


$query = AssetPhotoChange::with([
    'user',
    'asset',
]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $changes = $query
            ->latest()
            ->get();

        return Inertia::render('AssetPhotoChanges/Index', [
            'changes' => $changes,
            'status' => $status,
        ]);
    }

    public function show(AssetPhotoChange $change)
    {
        return Inertia::render('AssetPhotoChanges/Show', [
            'change' => $change->load([
                'user',
                'approver',
                'asset',
            ]),
        ]);
    }

    public function approve(
        AssetPhotoChange $change,
        AssetPhotoApprovalService $approvalService
    ) {
        if ($change->status !== AssetPhotoChange::STATUS_PENDING) {
            return redirect()
                ->route('asset-photo-changes.index')
                ->with('error', 'This request has already been processed.');
        }

        DB::transaction(function () use ($change, $approvalService) {
            $approvalService->approve($change);
        });

        return redirect()
            ->route('asset-photo-changes.index')
            ->with('success', 'Photo approved successfully.');
    }

    public function reject(
        AssetPhotoChange $change,
        AssetPhotoApprovalService $service
    ) {
        $service->reject($change);

        return redirect()
            ->route('asset-photo-changes.index')
            ->with('success', 'Photo request rejected.');
    }
}
