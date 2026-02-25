<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'name', 'value', 'sku', 'price_modifier', 'stock', 'image', 'sort_order'];

    protected $casts = [
        'price_modifier' => 'decimal:2',
        'stock' => 'integer',
        'sort_order' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFinalPriceAttribute(): float
    {
        return (float) $this->product->price + (float) $this->price_modifier;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return $this->product->image_url;
        }
        return str_starts_with($this->image, 'http') ? $this->image : \Illuminate\Support\Facades\Storage::url($this->image);
    }
}
