<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'category', 'stock', 'price', 'expiration_date'
    ];

            public function isLowStock()
        {
            return $this->stock <= $this->low_stock_threshold;
        }

        public function sales()
        {
            return $this->belongsToMany(Sale::class, 'product_sale')
                        ->withPivot('quantity')
                        ->withTimestamps();
        }

}
