<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $guarded = [];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class , 'role_permissions')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_roles')->withTimestamps();
    }
}
