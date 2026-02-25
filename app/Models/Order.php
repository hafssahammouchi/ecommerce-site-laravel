<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_CARD = 'card';
    public const PAYMENT_ON_DELIVERY = 'on_delivery';

    protected $fillable = [
        'number', 'invoice_number', 'user_id', 'status', 'subtotal', 'delivery_price', 'total',
        'coupon_code', 'discount_amount', 'delivery_option', 'payment_method', 'customer_email', 'customer_phone',
        'shipping_name', 'shipping_address', 'shipping_city', 'shipping_postal_code', 'shipping_country',
        'shipping_lat', 'shipping_lng', 'notes', 'paid_at', 'shipped_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_price' => 'decimal:2',
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_lat' => 'decimal:7',
        'shipping_lng' => 'decimal:7',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
    ];

    public static function generateNumber(): string
    {
        do {
            $number = 'GB-' . strtoupper(Str::random(2)) . '-' . date('Ymd') . '-' . Str::padLeft((string) random_int(1, 9999), 4, '0');
        } while (static::where('number', $number)->exists());
        return $number;
    }

    public static function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $last = static::whereNotNull('invoice_number')->whereYear('created_at', $year)->max('invoice_number');
        $seq = $last ? (int) substr($last, -5) + 1 : 1;
        return 'FAC-' . $year . '-' . str_pad((string) $seq, 5, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getShippingCoordinatesAttribute(): ?array
    {
        if ($this->shipping_lat && $this->shipping_lng) {
            return ['lat' => (float) $this->shipping_lat, 'lng' => (float) $this->shipping_lng];
        }
        return null;
    }
}
