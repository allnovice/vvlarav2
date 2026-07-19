<?php

namespace App\Models;
use App\Models\AssetHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AssetChange;
use App\Models\AssetVerification;
use App\Models\AssetPhoto;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
    'property_number',
    'type',
    'description',
    'status',
    'photo_path',

    // Specifications
    'brand',
    'model',
    'serial_number',
    'manufacturer',

    // Assignment
    'assigned_to',
    'department',
    'location',

    // Acquisition
    'acquisition_date',
    'acquisition_cost',
    'supplier',
    'warranty_expiry',
    'verified_at',
    'verified_by',

];

protected function casts(): array
{
    return [
        'verified_at' => 'datetime',
    ];
}
public function history()
{
    return $this->hasMany(AssetHistory::class)
        ->latest('performed_at');
}
public function changes()
{
    return $this->hasMany(AssetChange::class);
}
public function pendingChange()
{
    return $this->hasOne(AssetChange::class)
        ->where('status', AssetChange::STATUS_PENDING);
}
public function verifications()
{
    return $this->hasMany(AssetVerification::class);
}
public function pendingVerification()
{
    return $this->hasOne(AssetVerification::class)
        ->where('status', AssetVerification::STATUS_PENDING);
}
public function photos()
{
    return $this->hasMany(AssetPhoto::class)
        ->orderBy('sort_order');
}

}
