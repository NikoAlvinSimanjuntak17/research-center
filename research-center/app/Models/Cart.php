<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'event_id', 'research_data_id', 'price', 'file_path', 'item_type'];

    protected $casts = [
    'file_path' => 'array',
    ];

    public function event()
{
    return $this->belongsTo(Event::class, 'event_id');
}

public function research_data()
{
    return $this->belongsTo(ResearchData::class, 'research_data_id');
}

}
