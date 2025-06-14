<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Storage;

class AdminNewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::where('active', 1)->get();
        return view('admin.news.create', compact('categories'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'news_category_id' => 'nullable|exists:news_categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destination = public_path('storage/news_images');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);
        $data['image'] = 'news_images/' . $fileName;
    }

    $data['created_by'] = auth()->id();
    $data['active'] = true;

    News::create($data);

    return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
}


    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('active', 1)->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

public function update(Request $request, News $news)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'news_category_id' => 'nullable|exists:news_categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destination = public_path('storage/news_images');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);
        $data['image'] = 'news_images/' . $fileName;
    }

    $data['updated_by'] = auth()->id();

    $news->update($data);

    return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
}


    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
