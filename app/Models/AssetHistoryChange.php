<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetHistoryChange extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'asset_id',
        'user_id',

        'type',
        'title',
        'description',
        'performed_by',
        'performed_at',
        'remarks',

        'status',

        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'performed_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }
public function asset()
{
    return $this->belongsTo(Asset::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}


}
