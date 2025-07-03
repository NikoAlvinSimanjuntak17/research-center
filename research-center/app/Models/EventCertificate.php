<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCertificate extends Model
{
    use HasFactory;

    protected $table = 'event_certificates';

    protected $fillable = [
        'event_registration_id',
        'user_id',
        'event_id',
        'certificate_link',
        'issued_at',
    ];
    public $timestamps = false;

    // Relasi ke tabel EventRegistration
    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'event_registration_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
