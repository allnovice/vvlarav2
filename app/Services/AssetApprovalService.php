<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetChange;
use Illuminate\Validation\ValidationException;

class AssetApprovalService
{
    /**
     * Create a new class instance.
     */
public function approve(AssetChange $change): void
{

    if ($change->status !== AssetChange::STATUS_PENDING) {
        throw ValidationException::withMessages([
            'change' => 'This request has already been processed.',
        ]);
    }

    if ($change->user_id === auth()->id()) {
        throw ValidationException::withMessages([
            'change' => 'You cannot approve your own request.',
        ]);
    }

switch ($change->action) {

    case AssetChange::ACTION_CREATE:
        $this->approveCreate($change);
        break;

    case AssetChange::ACTION_UPDATE:
        $this->approveUpdate($change);
        break;

    case AssetChange::ACTION_DELETE:
        $this->approveDelete($change);
        break;
}




    $change->update([
        'status' => AssetChange::STATUS_APPROVED,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);
}
private function approveCreate(AssetChange $change): void
{
    Asset::create($change->data);
}
private function approveUpdate(AssetChange $change): void
{
    $change->asset->update($change->data);
}
private function approveDelete(AssetChange $change): void
{
    $asset = $change->asset;

    if ($asset->photo_path) {
        Storage::disk('public')->delete($asset->photo_path);
    }

    $asset->delete();
}
public function reject(AssetChange $change): void
{
    if ($change->status !== AssetChange::STATUS_PENDING) {
        throw ValidationException::withMessages([
            'change' => 'This request has already been processed.',
        ]);
    }

    if ($change->user_id === auth()->id()) {
        throw ValidationException::withMessages([
            'change' => 'You cannot reject your own request.',
        ]);
    }

    $change->update([
        'status' => AssetChange::STATUS_REJECTED,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);
}

}

