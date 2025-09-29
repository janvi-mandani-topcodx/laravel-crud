<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $fillable = [
        'id',
        'code',
        'amount',
        'type',
        'minimum_requirements',
        'minimum_amount',
        'customer',
        'user_id',
        'product',
        'product_id',
        'discount_apply_type',
        'discount_type_number',
        'start_date',
        'end_date',
        'status',
    ];
}
