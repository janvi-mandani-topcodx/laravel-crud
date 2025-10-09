<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    public $fillable = [
        'id',
        'order_id',
        'payment_id',
        'amount',
        'refunded_amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
