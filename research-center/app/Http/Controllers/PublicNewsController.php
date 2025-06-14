<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    /**
     * Tampilkan daftar berita untuk publik.
     */
    public function index()
    {
       $news = News::latest()->paginate(4);
       $archivedNews = News::where('created_at', '<', now()->subMonth())->latest()->limit(5)->get();

       return view('news', compact('news', 'archivedNews'));       
    }

    /**
     * Tampilkan detail berita tertentu.
     */
    public function show($id)
    {
        $news = News::where('id', $id)->orWhere('id', $id)->firstOrFail();
        return view('shownews', compact('news'));
    }
}