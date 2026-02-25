<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order', 'usage_limit', 'used_count',
        'valid_from', 'valid_until', 'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(float $subtotal = 0): bool
    {
        if (!$this->is_active) {
            return false;
        }
        if ($this->valid_from && now()->lt($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && now()->gt($this->valid_until)) {
            return false;
        }
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }
        if ($this->min_order !== null && $subtotal < (float) $this->min_order) {
            return false;
        }
        return true;
    }

    public function discountAmount(float $subtotal): float
    {
        if ($this->type === 'percent') {
            return round($subtotal * ((float) $this->value / 100), 2);
        }
        return min((float) $this->value, $subtotal);
    }
}
