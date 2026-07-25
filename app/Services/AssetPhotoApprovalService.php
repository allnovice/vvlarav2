<?php

namespace App\Services;

use App\Models\AssetPhoto;
use App\Models\AssetPhotoChange;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Services\ImageService;

class AssetPhotoApprovalService
{
    public function approve(AssetPhotoChange $change): void
    {
        if ($change->status !== AssetPhotoChange::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'change' => 'This request has already been processed.',
            ]);
        }

        if ($change->submitted_by === auth()->id()) {
            throw ValidationException::withMessages([
                'change' => 'You cannot approve your own request.',
            ]);
        }


switch ($change->action) {
    case AssetPhotoChange::ACTION_UPLOAD:
        $this->approveUpload($change);
        break;
    case AssetPhotoChange::ACTION_EDIT:
        $this->approveEdit($change);
        break;
    case AssetPhotoChange::ACTION_DELETE:
        $this->approveDelete($change);
        break;
}


        $change->update([
            'status' => AssetPhotoChange::STATUS_APPROVED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
    }

    
private function approveUpload(AssetPhotoChange $change): void
{
    $image = app(ImageService::class)
        ->approvePendingPhoto($change->photo_path);

    AssetPhoto::create([
        'asset_id' => $change->asset_id,
        'photo_path' => $image['photo_path'],
        'photo_thumb_path' => $image['photo_thumb_path'],
        'caption' => $change->caption,
        'sort_order' => $change->asset->photos()->count(),
    ]);
}
private function approveEdit(AssetPhotoChange $change): void
{
    $photo = AssetPhoto::findOrFail($change->asset_photo_id);

    $photo->update([
        'caption' => $change->caption,
    ]);
}

private function approveDelete(AssetPhotoChange $change): void
{
    $photo = AssetPhoto::findOrFail($change->asset_photo_id);

    Storage::disk('public')->delete($photo->photo_path);

    if ($photo->photo_thumb_path) {
        Storage::disk('public')->delete($photo->photo_thumb_path);
    }

    $photo->delete();
}




    public function reject(AssetPhotoChange $change): void
    {
        if ($change->status !== AssetPhotoChange::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'change' => 'This request has already been processed.',
            ]);
        }

        if ($change->submitted_by === auth()->id()) {
            throw ValidationException::withMessages([
                'change' => 'You cannot reject your own request.',
            ]);
        }

        Storage::disk('public')->delete($change->photo_path);

        $change->update([
            'status' => AssetPhotoChange::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
    }
}
