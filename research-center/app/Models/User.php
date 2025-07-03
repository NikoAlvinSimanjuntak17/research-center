<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Traits\HasRolesAndPermissions;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_img',
        'phone',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke roles (bawaan Laratrust, biasanya ga perlu ini kalau pakai trait)
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Relasi ke tabel Researcher
    public function researcher()
    {
        return $this->hasOne(Researcher::class);
    }

    // Contoh relasi order (kalau memang kamu punya tabel orders)
    public function order()
    {
        return $this->hasMany(Order::class, 'id');
    }
    public function collaborations()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function publications()
    {
        return $this->hasManyThrough(
            \App\Models\Publication::class,   // Model tujuan akhir
            \App\Models\Researcher::class,    // Model perantara
            'user_id',                        // Foreign key di tabel researchers
            'researcher_id',                  // Foreign key di tabel publications
            'id',                             // Local key di tabel users
            'id'                              // Local key di tabel researchers
        );
    }
}