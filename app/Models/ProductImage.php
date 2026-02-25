<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'sort_order', 'alt'];

    protected $casts = ['sort_order' => 'integer'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        return str_starts_with($this->path, 'http') ? $this->path : \Illuminate\Support\Facades\Storage::url($this->path);
    }
}
