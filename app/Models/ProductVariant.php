<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    public $fillable = [
        'id',
        'title',
        'price',
        'sku'
    ];

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
