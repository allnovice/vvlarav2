<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetPhoto extends Model
{
    protected $fillable = [
        'asset_id',
        'photo_path',
        'caption',
        'sort_order',
        'photo_thumb_path',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
