<?php

namespace App\Http\Controllers;

use App\Models\AssetVerification;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Services\AssetVerificationApprovalService;
use App\Models\AssetVerificationPhoto;
use App\Services\ImageService;

class AssetVerificationController extends Controller
{

public function index()
{
    $status = request('status', AssetVerification::STATUS_PENDING);

    $query = AssetVerification::with([
        'asset',
        'user',
    ]);

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $verifications = $query
        ->latest()
        ->get();

    return inertia('AssetVerifications/Index', [
        'verifications' => $verifications,
        'status' => $status,
    ]);
}


public function store(Request $request, Asset $asset, ImageService $imageService)
{
    $validated = $request->validate([
        'remarks' => ['nullable', 'string'],
        'attachment' => ['nullable', 'file', 'max:5120'],
        'photos' => ['required', 'array'],
        'photos.*' => ['image', 'max:5120'],
    ]);

    if (
        $asset->verifications()
            ->where('status', AssetVerification::STATUS_PENDING)
            ->exists()
    ) {
        return back()->with(
            'error',
            'A verification request is already pending.'
        );
    }

$attachmentPath = null;

if ($request->hasFile('attachment')) {

    $attachmentPath = $request->file('attachment')
        ->store('asset-verifications', 'public');
}
    $verification =
    AssetVerification::create([
        'asset_id' => $asset->id,
        'user_id' => auth()->id(),
        'status' => AssetVerification::STATUS_PENDING,
        'remarks' => $validated['remarks'] ?? null,
        'attachment_path' => $attachmentPath,
    ]);

if ($request->hasFile('photos')) {

    foreach ($request->file('photos') as $file) {

        $photoPath = $file->store(
            'asset-verifications',
            'public'
        );

        $thumbPath = 'asset-verifications/thumbs/' . basename($photoPath);

        $imageService->generateThumbnail(
            $photoPath,
            $thumbPath
        );

        AssetVerificationPhoto::create([
            'asset_verification_id' => $verification->id,
            'photo_path' => $photoPath,
            'photo_thumb_path' => $thumbPath,
        ]);
    }
}

    return back()->with(
        'success',
        'Verification request submitted.'
    );
}


public function show(AssetVerification $assetVerification)
{
    $assetVerification->load([
        'asset',
        'user',
        'reviewer',
        'photos',
    ]);

    return inertia('AssetVerifications/Show', [
        'verification' => $assetVerification,
    ]);
}
public function approve(
    Request $request,
    AssetVerification $assetVerification,
    AssetVerificationApprovalService $service
)
{
    $service->approve(
        $assetVerification,
        $request->input('reviewer_remarks')
    );
    return redirect()
        ->route('asset-verifications.index')
        ->with('success', 'Verification approved.');
}
public function reject(

    Request $request,
    AssetVerification $assetVerification,
    AssetVerificationApprovalService $service
)
{

    $service->reject(
        $assetVerification,
        $request->input('reviewer_remarks')
    );

    return redirect()
        ->route('asset-verifications.index')
        ->with('success', 'Verification rejected.');
}



}
