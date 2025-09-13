<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];
    public function user()
    {
        return  $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    protected function imageUrl() : Attribute
    {
        return Attribute::make(
            get: function (){
                    $postImage = $this->getFirstMedia('posts');
                    if($postImage){
                        return $postImage->getUrl();
                    }
                    return null;
                }
        );
    }
    protected function fullName() : Attribute
    {
        return Attribute::make(
            get: function (){
                return $this->user->first_name . ' ' . $this->user->last_name;
            }
        );
    }
}
