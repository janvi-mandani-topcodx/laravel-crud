<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    protected function postImageUrl() : Attribute
    {
        return Attribute::make(
            get: function (){
                return asset('storage/' . $this->image);
            }
        );
    }
}
