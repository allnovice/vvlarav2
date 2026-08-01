<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaintenancePhoto;

class AssetHistory extends Model
{
    protected $fillable = [
        'asset_id',
        'asset_history_change_id',
        'type',
        'title',
        'description',
        'performed_by',
        'performed_at',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'performed_at' => 'datetime',
        ];
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
public function photos()
{
    return $this->hasMany(MaintenancePhoto::class);
}
}
