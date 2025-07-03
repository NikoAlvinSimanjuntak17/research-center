<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    protected $fillable = ['name', 'address', 'website'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}

