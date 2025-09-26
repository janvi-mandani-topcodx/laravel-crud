<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail , HasMedia
{
    use HasFactory, Notifiable , HasRoles , InteractsWithMedia;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

//    protected function imageUrl() : Attribute
//    {
//        return Attribute::make(
//            get: function (){
//                return asset('storage/' . $this->image);
//            }
//        );
//    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

//    public function roles()
//    {
//        return $this->belongsToMany(CustomRole::class , 'user_roles')->withTimestamps();
//    }

    protected function fullName() : Attribute
    {
        return Attribute::make(
            get: function (){
                return $this->first_name . ' ' . $this->last_name;
            }
        );
    }

    protected function imageUrl() : Attribute
    {
        return Attribute::make(
            get: function (){
                $userImage = $this->getFirstMedia('users');
                if($userImage){
                    return $userImage->getUrl();
                }
                return null;
            }
        );
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

}
