<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];
    protected $fillable = ['name', 'display_name', 'description'];
}

