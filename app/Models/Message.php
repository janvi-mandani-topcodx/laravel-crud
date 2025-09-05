<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class , 'admin_id');
    }

    public function messageReplies()
    {
        return $this->hasMany(MessageReply::class);
    }
}
