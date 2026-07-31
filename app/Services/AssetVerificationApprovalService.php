<?php

namespace App\Services;

use App\Models\AssetVerification;
use Illuminate\Validation\ValidationException;

class AssetVerificationApprovalService
{

public function approve(AssetVerification $verification, ?string $remarks = null): void
{
    if ($verification->status !== AssetVerification::STATUS_PENDING) {
        throw ValidationException::withMessages([
            'verification' => 'This verification request has already been processed.',
        ]);
    }

    if ($verification->user_id === auth()->id()) {
        throw ValidationException::withMessages([
            'verification' => 'You cannot approve your own verification.',
        ]);
    }

$verification->update([
    'status' => AssetVerification::STATUS_APPROVED,
    'reviewed_by' => auth()->id(),
    'reviewed_at' => now(),
    'reviewer_remarks' => $remarks,
]);

$verification->asset->update([
    'verified_at' => $verification->asset->verified_at ?? now(),
    'verified_by' => auth()->id(),
    'last_verified_at' => now(),
    'next_verification_due' => now()->addMonths(6),
]);

}
public function reject(
    AssetVerification $verification,
    ?string $remarks = null
): void
{
    if ($verification->status !== AssetVerification::STATUS_PENDING) {
        throw ValidationException::withMessages([
            'verification' => 'This verification request has already been processed.',
        ]);
    }

    if ($verification->user_id === auth()->id()) {
        throw ValidationException::withMessages([
            'verification' => 'You cannot reject your own verification.',
        ]);
    }

    $verification->update([
        'status' => AssetVerification::STATUS_REJECTED,
        'reviewed_by' => auth()->id(),
        'reviewed_at' => now(),
        'reviewer_remarks' => $remarks,
    ]);
}

}
