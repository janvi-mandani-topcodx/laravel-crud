<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    protected function firstLetter() : Attribute
    {
        return Attribute::make(
            get: function (){
                return $this->user->first_name . ' ' . $this->user->last_name;
            }
        );
    }
}
