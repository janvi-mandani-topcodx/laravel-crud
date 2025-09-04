<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    public $guarded = [];
    public function messages()
    {
        return  $this->belongsTo(Message::class);
    }
}
