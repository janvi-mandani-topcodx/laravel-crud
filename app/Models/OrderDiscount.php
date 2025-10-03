<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    public $fillable = [
        'id',
        'order_id',
        'code',
        'type',
        'amount',
        'discount_name',
    ];
}
