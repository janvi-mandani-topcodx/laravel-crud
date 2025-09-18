<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserDemo extends Model implements HasMedia
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
        'id'          => 'integer',
        'first_name'  => 'string',
        'last_name'   => 'string',
        'email'       => 'string',
        'password'    => 'string',
        'hobbies'     => 'array',
        'status'      => 'boolean',
    ];


}
