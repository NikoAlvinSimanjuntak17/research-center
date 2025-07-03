<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'time',
        'people',
        'image', 
        'description',
        'price',
        'event_type',
        'status',
        'registration_start_date',
        'registration_end_date',
        'attendance_token',
        'created_by',
        'updated_by'
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke user yang terakhir mengupdate researcher
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function event()
{
    return $this->belongsTo(Event::class);
}

}
