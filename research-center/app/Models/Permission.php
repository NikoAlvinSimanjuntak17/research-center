<?php

namespace App\Models;

use Laratrust\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    public $guarded = [];
    protected $fillable = ['name', 'display_name', 'description'];
}
