<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDiscount extends Model
{
    public $fillable = [
        'id',
        'user_id',
        'code',
        'type',
        'amount',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
