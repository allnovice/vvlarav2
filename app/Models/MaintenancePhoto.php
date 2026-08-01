<?php

namespace App\Models;

use App\Models\AssetHistory;
use Illuminate\Database\Eloquent\Model;

class MaintenancePhoto extends Model
{
    protected $fillable = [
        'asset_history_id',
        'photo_path',
        'photo_thumb_path',
    ];

    public function assetHistory()
    {
        return $this->belongsTo(AssetHistory::class);
    }
}
