<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Profile;
use App\Models\Gallery;
use App\Models\Researcher;


class HomeController extends Controller
{
public function index()
{
    $sliders = Slider::where('active', true)->latest()->get();
    $about = Profile::where('key', 'about')->where('active', 1)->latest()->first();
    $news = News::orderBy('created_at', 'desc')->take(3)->get();
    $visiMisi = Profile::where('key', 'Visi Misi')->where('active', 1)->get();
    $galleries = Gallery::with('files')
                    ->where('active', 1)
                    ->latest()
                    ->take(4)
                    ->get();

    $researchers = Researcher::with('user')  // agar bisa akses $researcher->user->name
                    ->latest()
                    ->take(3)
                    ->get();
    return view('welcome', compact('sliders', 'about', 'news','visiMisi','galleries','researchers'));
}

}
