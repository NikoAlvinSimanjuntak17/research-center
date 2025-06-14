<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryController
{
    public function publicIndex()
    {
        $galleries = Gallery::latest()->paginate(12); // Mengambil 12 gambar per halaman
        return view('galleries', compact('galleries'));
    }
}