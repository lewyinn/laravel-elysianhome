<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id',
        'order_number',
        'shipping_address',
        'payment_method',
        'total_price',
        'status',
        'snap_token',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'total_price' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
