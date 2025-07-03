<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'order_id',
        'attendance_token',
        'token_verified',
    ];

    /**
     * Get the event associated with the registration.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }


    /**
     * Get the researcher associated with the registration.
     */
    public function researcher()
    {
        return $this->belongsTo(Researcher::class);
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

// EventRegistration.php

public function certificate()
{
    return $this->hasOne(EventCertificate::class, 'event_registration_id');
}
// EventRegistration.php
public function order()
{
    return $this->belongsTo(Order::class, 'order_id');
}


}
