<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image',
        'created_by',
        'updated_by',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
