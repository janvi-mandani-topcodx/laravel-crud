<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    public $fillable = [
        'user_id',
        'balance',
        'code',
        'notes',
        'expiry_at',
        'enabled',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
