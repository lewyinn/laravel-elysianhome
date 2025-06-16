<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    //
    protected $fillable = ['user_id'];

    // Relasi: keranjang milik user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: keranjang punya banyak item
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
