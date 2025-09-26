<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UsersDemo extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'hobbies',
        'status'
    ];

    protected $casts = [
        'hobbies'     => 'array',
        'status'      => 'boolean',
    ];

    function getImageUrlAttribute()
    {
        $img = [];
        $userImage = $this->getMedia('users-demo');
        if($userImage){
            foreach ($userImage as $image) {
                $img[] =  $image->getUrl();
            }
            return $img;
        }
        return null;
    }
}
