<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name', 'generic_name', 'brand', 'category', 'dosage_form',
        'dosage_strength', 'dosage_unit', 'weight_grams', 'manufacturer',
        'batch_number', 'manufacture_date', 'expiry_date', 'stock_quantity',
        'reorder_level', 'unit_price', 'selling_price', 'storage_condition',
        'requires_prescription', 'description', 'side_effects',
        'contraindications', 'status',
    ];

    protected $casts = [
        'manufacture_date' => 'date',
        'expiry_date' => 'date',
        'requires_prescription' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function supplyRequests()
    {
        return $this->hasMany(SupplyRequest::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }
}
