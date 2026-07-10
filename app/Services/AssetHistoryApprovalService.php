<?php

namespace App\Services;

use App\Models\AssetHistory;
use App\Models\AssetHistoryChange;
use Illuminate\Validation\ValidationException;

class AssetHistoryApprovalService
{

public function approve(AssetHistoryChange $change): void
{
    if ($change->status !== AssetHistoryChange::STATUS_PENDING) {
        throw ValidationException::withMessages([
            'change' => 'This history request has already been processed.',
        ]);
    }

    if ($change->user_id === auth()->id()) {
        throw ValidationException::withMessages([
            'change' => 'You cannot approve your own history request.',
        ]);
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
}
public function reject(AssetHistoryChange $change): void
{
    if ($change->status !== AssetHistoryChange::STATUS_PENDING) {
        throw ValidationException::withMessages([
            'change' => 'This history request has already been processed.',
        ]);
    }

    if ($change->user_id === auth()->id()) {
        throw ValidationException::withMessages([
            'change' => 'You cannot reject your own history request.',
        ]);
    }

    $change->update([
        'status' => AssetHistoryChange::STATUS_REJECTED,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);
}


}
