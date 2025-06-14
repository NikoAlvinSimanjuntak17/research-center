<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'description',
        'news_category_id',
        'image',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    // Optional: untuk preview deskripsi pendek
    public function shortDescription($limit = 100)
    {
        return Str::limit(strip_tags($this->description), $limit);
    }
}
