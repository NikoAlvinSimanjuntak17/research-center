<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'order_id', 'research_data_id', 'user_id', 'review'
    ];

    public function researchData()
    {
        return $this->belongsTo(ResearchData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
