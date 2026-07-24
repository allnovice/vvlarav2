<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetPhotoChange;
use Illuminate\Http\Request;
use App\Models\AssetPhoto;

class AssetPhotoController extends Controller
{
    public function store(Request $request, Asset $asset)
    {


$request->validate([
    'photos' => ['required', 'array'],
    'photos.*' => [
        'image',
        'max:' . config('cmms.asset_photos.max_per_photo_kb'),
    ],
]);

$maxPhotos = config('cmms.asset_photos.max_per_asset');

$approvedPhotos = AssetPhoto::where('asset_id', $asset->id)
    ->count();

$pendingUploads = AssetPhotoChange::where('asset_id', $asset->id)
    ->where('action', AssetPhotoChange::ACTION_UPLOAD)
    ->where('status', AssetPhotoChange::STATUS_PENDING)
    ->count();

$requestedPhotos = count($request->file('photos'));

$totalAfterUpload = $approvedPhotos + $pendingUploads + $requestedPhotos;

if ($totalAfterUpload > $maxPhotos) {

    $availableSlots = max(
        0,
        $maxPhotos - ($approvedPhotos + $pendingUploads)
    );

    return back()->withErrors([
        'photos' => "This asset can have a maximum of {$maxPhotos} additional photos. Only {$availableSlots} slot(s) remaining.",
    ]);
}

        foreach ($request->file('photos') as $file) {

            $path = $file->store('assets/pending', 'public');


AssetPhotoChange::create([
    'asset_id' => $asset->id,
    'submitted_by' => auth()->id(),
    'action' => AssetPhotoChange::ACTION_UPLOAD,
    'photo_path' => $path,
    'caption' => $request->caption,
    'status' => AssetPhotoChange::STATUS_PENDING,
]);


        }

        return back()->with(
            'success',
            'Photos submitted for approval.'
        );
    }

public function requestCaptionUpdate(Request $request, AssetPhoto $photo)
{


if ($this->hasPendingRequest($photo)) {
    return back()->withErrors([
        'change' => 'This photo already has a pending request.',
    ]);
}



    $validated = $request->validate([
        'caption' => ['nullable', 'string', 'max:255'],
    ]);

    AssetPhotoChange::create([
        'asset_id' => $photo->asset_id,
        'asset_photo_id' => $photo->id,
        'photo_path' => $photo->photo_path,
        'submitted_by' => auth()->id(),
        'action' => AssetPhotoChange::ACTION_EDIT,
        'caption' => $validated['caption'],
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);

    return back()->with('success', 'Caption update submitted for approval.');
}

public function requestDelete(AssetPhoto $photo)
{
    if ($this->hasPendingRequest($photo)) {
        return back()->withErrors([
            'change' => 'This photo already has a pending request.',
        ]);
    }

    AssetPhotoChange::create([
        'asset_id' => $photo->asset_id,
        'asset_photo_id' => $photo->id,
        'submitted_by' => auth()->id(),
        'action' => AssetPhotoChange::ACTION_DELETE,
        'photo_path' => $photo->photo_path,
        'caption' => $photo->caption,
        'status' => AssetPhotoChange::STATUS_PENDING,
    ]);

    return back()->with(
        'success',
        'Photo deletion submitted for approval.'
    );
}

private function hasPendingRequest(AssetPhoto $photo): bool
{
    return AssetPhotoChange::where(
        'asset_photo_id',
        $photo->id
    )
    ->where('status', AssetPhotoChange::STATUS_PENDING)
    ->exists();
}



}
