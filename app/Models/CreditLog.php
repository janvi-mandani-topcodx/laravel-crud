<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    public $fillable = [
        'user_id',
        'previews_balance',
        'new_balance',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
