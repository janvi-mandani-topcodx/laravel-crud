<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $fillable = [
        'id',
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
    ];
    protected $casts = [
        'shipping_details' => 'array',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

}
