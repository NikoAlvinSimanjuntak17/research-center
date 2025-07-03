<?php

namespace App\Models;

use Laratrust\Models\Role as LaratrustRole;


class Role extends LaratrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
