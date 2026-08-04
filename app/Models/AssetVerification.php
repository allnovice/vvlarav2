<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetVerification extends Model
{
protected $fillable = [
    'asset_id',
    'user_id',
    'status',
    'reviewed_by',
    'reviewed_at',
    'remarks',
    'attachment_path',
    'reviewer_remarks',
];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
public function photos()
{
    return $this->hasMany(AssetVerificationPhoto::class);
}
}
