<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    public function users()
    {
        return  $this->belongsToMany(User::class);
    }
    protected function postimageUrl() : Attribute
    {
        return Attribute::make(
            get: function (){
                return asset('storage/' . $this->image);
            }
        );
    }
}
