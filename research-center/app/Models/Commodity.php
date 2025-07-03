<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',         // kategori (bisa reuse atau baru)
        'name',        // nama komoditas
        'description',   // penjelasan
        'image',       // path ke gambar
    ];
}
