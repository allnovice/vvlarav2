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
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
