<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Str;


class ResearchData extends Model
{
    use HasFactory;

    protected $table = 'research_datas'; // Sesuai dengan nama tabel di database

    protected $fillable = [
        'research_title',
        'abstract',
        'price',
        'research_category_name',
        'research_category_id',
        'researcher_name',
        'researcher_id',
        'year',
        'doi',
        'file_path',
        'preview_path',
        'time',
        'created_by',
        'updated_by'
    ];
    protected $casts = [
    'file_path' => 'array',
];


    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class, 'research_category_id');
    }

    // Relasi ke tabel researchers
    public function researcher()
    {
        return $this->belongsTo(Researcher::class, 'researcher_id');
    }
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
    public function reviews()
{
    return $this->hasMany(Review::class, 'research_data_id');
}

}
