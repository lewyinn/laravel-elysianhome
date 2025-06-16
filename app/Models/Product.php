<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image', 'category_id',
    ];

    // Relasi: produk milik kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
