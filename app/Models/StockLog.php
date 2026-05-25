<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'medicine_id', 'staff_id', 'type', 'quantity',
        'stock_before', 'stock_after', 'batch_number', 'expiry_date', 'notes',
        'status', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'expiry_date'  => 'date',
        'approved_at'  => 'datetime',
    ];

    public function medicine() { return $this->belongsTo(Medicine::class); }
    public function staff()    { return $this->belongsTo(User::class, 'staff_id'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
}
