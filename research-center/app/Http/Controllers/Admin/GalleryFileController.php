<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryFileController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with(['files.creator'])->latest()->get();
        return view('admin.gallery_files.index', compact('galleries'));
    }

    public function create()
    {
        $galleries = Gallery::select('id', 'title')->get(); // PASTIKAN ini koleksi model
        return view('admin.gallery_files.create', compact('galleries'));
    }

public function store(Request $request)
{
    $request->validate([
        'gallery_id' => 'required|exists:galleries,id',
        'images'     => 'required|array',
        'images.*'   => 'image|max:2048',
    ]);

    foreach ($request->file('images') as $image) {
        $fileName = time() . '_' . $image->getClientOriginalName();
        $destination = public_path('storage/gallery_images');

        // Buat folder kalau belum ada
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Pindahkan file ke public
        $image->move($destination, $fileName);

        // Simpan path relatif ke DB
        GalleryFile::create([
            'gallery_id' => $request->gallery_id,
            'image'      => 'gallery_images/' . $fileName,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
    }

    return redirect()->route('admin.gallery_files.index')->with('message', 'Gambar berhasil ditambahkan.');
}


    public function edit(GalleryFile $galleryFile)
    {
        $galleries = Gallery::select('id', 'title')->get(); // ganti dari pluck
        return view('admin.gallery_files.edit', compact('galleryFile', 'galleries'));
    }

public function update(Request $request, GalleryFile $galleryFile)
{
    $request->validate([
        'gallery_id' => 'required|exists:galleries,id',
        'image'      => 'nullable|image|max:2048',
    ]);

    $data = [
        'gallery_id' => $request->gallery_id,
        'updated_by' => Auth::id(),
    ];

    if ($request->hasFile('image')) {
        // Hapus file lama (kalau ada)
        if ($galleryFile->image && file_exists(public_path($galleryFile->image))) {
            unlink(public_path($galleryFile->image));
        }

        $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
        $destination = public_path('storage/gallery_images');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $request->file('image')->move($destination, $fileName);
        $data['image'] = 'gallery_images/' . $fileName;
    }

    $galleryFile->update($data);

    return redirect()->route('admin.gallery_files.index')->with('message', 'Gambar berhasil diperbarui.');
}


    public function destroy(GalleryFile $galleryFile)
    {
        if ($galleryFile->image && Storage::disk('public')->exists($galleryFile->image)) {
            Storage::disk('public')->delete($galleryFile->image);
        }

        $galleryFile->delete();

        return redirect()->route('admin.gallery_files.index')->with('message', 'Gambar berhasil dihapus.');
    }
}
