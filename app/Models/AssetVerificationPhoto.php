<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetVerificationPhoto extends Model
{
    protected $fillable = [
        'asset_verification_id',
        'photo_path',
        'photo_thumb_path',
    ];

    public function verification()
    {
        return $this->belongsTo(AssetVerification::class);
    }
}
