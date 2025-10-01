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
        'customer_eligibility',
        'customer_id',
        'applies_product',
        'product_id',
        'usage_limit_number_of_times_use',
        'usage_limit_number',
        'usage_limit_one_user_per_customer',
        'usage_limit_new_customer',
        'start_date',
        'end_date',
        'status',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class , 'customer_id');
    }
}
