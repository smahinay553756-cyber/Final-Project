<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'total_amount', 'status',
        'payment_method', 'payment_status', 'notes',
        'prescription_required', 'prescription_file',
        'dispensed_by', 'dispensed_at',
        'is_walkin', 'walkin_name',
    ];

    protected $casts = [
        'dispensed_at'           => 'datetime',
        'is_walkin'              => 'boolean',
        'prescription_required'  => 'boolean',
    ];

    public function getCustomerNameAttribute(): string
    {
        return $this->is_walkin ? ($this->walkin_name ?? 'Walk-in Customer') : ($this->user?->name ?? 'Unknown');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function dispenser()
    {
        return $this->belongsTo(User::class, 'dispensed_by');
    }
}
