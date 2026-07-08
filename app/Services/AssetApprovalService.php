<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetChange;

class AssetApprovalService
{
    /**
     * Create a new class instance.
     */
public function approve(AssetChange $change): void
{

    if ($change->status !== AssetChange::STATUS_PENDING) {
        throw new \RuntimeException('This request has already been processed.');
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

}

