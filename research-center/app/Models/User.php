<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\HasRolesAndPermissions;
use App\Models\Researcher;
use App\Models\Collaborator;
use App\Models\Project;
use App\Models\Institution;
use App\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function researcher()
    {
        return $this->hasOne(Researcher::class, 'user_id');
    }

    public function scopeFindByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%")->first();
    }

    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'collaborators')
                    ->withPivot(['position', 'institution', 'department', 'expertise', 'cv', 'reason', 'status', 'is_leader'])
                    ->withTimestamps();
    }

    // app/Models/User.php
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relasi dengan publications
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
    
}
