<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    public $fillable = [
        'user_id',
        'old_credit',
        'new_credit',
        'description',
    ];
}
