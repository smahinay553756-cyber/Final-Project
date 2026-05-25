<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'phone', 'address', 'approved',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'approved'          => 'boolean',
        ];
    }

    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isCustomer(): bool   { return $this->role === 'customer'; }
    public function isStaff(): bool      { return $this->role === 'staff'; }
    public function isSuperAdmin(): bool { return $this->role === 'superadmin'; }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
