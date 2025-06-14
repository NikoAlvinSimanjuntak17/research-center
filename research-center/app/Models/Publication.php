<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Researcher;
use App\Models\Project;

class Publication extends Model
{
    protected $table = 'publications';

    // Kolom yang dapat diisi
    protected $fillable = [
        'project_id', // Ganti ke project_id jika ada relasi ke Project
        'researcher_id', 'title', 'abstract', 'journal', 'doi',
        'publication_date', 'source', 'external_id', 'authors', 'url', 'raw_data', 'type', 'citation_count'
    ];

    // Casting kolom ke tipe data yang sesuai
    protected $casts = [
        'authors' => 'array',           // Mengonversi JSON menjadi array
        'raw_data' => 'array',          // Mengonversi JSON menjadi array
        'publication_date' => 'date',   // Mengonversi tanggal secara otomatis (pastikan formatnya konsisten)
        'citation_count' => 'integer',  // Jika citation_count disimpan sebagai integer
    ];

    // Relasi de ngan researcher
    public function researchers()
    {
        return $this->belongsToMany(Researcher::class, 'publication_researcher', 'publication_id', 'researcher_id');
    }



    /**
     * Jika `publication_date` perlu diformat khusus, Anda bisa menambahkan method ini:
     */
    public function getFormattedPublicationDateAttribute()
    {
        return $this->publication_date ? $this->publication_date->format('Y-m-d') : null;
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
// Compare this snippet from app/Models/Researcher.php: