<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'department',
    'position',
    'contact_no',
    'role',
    'is_active',
    'verified_at',
    'verified_by',
    'avatar',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function isAdmin(): bool
{
    return $this->role === 'admin';
}
public function isPropertySupplyOfficer(): bool
{
    return $this->role === 'property_supply_officer';
}
public function isTechnician(): bool
{
    return $this->role === 'technician';
}
public function isEmployee(): bool
{
    return $this->role === 'employee';
}
public function isITHead(): bool
{
    return $this->role === 'it_head';
}
public function canApprove(): bool
{
    return $this->isAdmin()
        || $this->isITHead()
        || $this->isPropertySupplyOfficer();
}
public function canApproveUsers(): bool
{
    return $this->isITHead();
}

}
