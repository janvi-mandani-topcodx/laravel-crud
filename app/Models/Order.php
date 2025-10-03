<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'id',
        'user_id',
        'shipping_details',
        'delivery',
        'total',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderDiscounts()
    {
        return $this->hasMany(OrderDiscount::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
