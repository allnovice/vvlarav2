<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetPhotoChange extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const ACTION_UPLOAD = 'upload';
    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';

    protected $fillable = [
        'asset_id',
        'submitted_by',
        'action',
        'photo_path',
        'caption',
        'status',
        'reviewed_by',
        'reviewed_at',
        'remarks',
        'asset_photo_id',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    public function assetPhoto()
    {
        return $this->belongsTo(AssetPhoto::class);
    }



}
