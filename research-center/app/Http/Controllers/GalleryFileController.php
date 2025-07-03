<?php

namespace App\Http\Controllers;

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
        return view('gallery_files.index', compact('galleries'));
    }

    public function create()
    {
        $galleries = Gallery::select('id', 'title')->get(); // PASTIKAN ini koleksi model
        return view('gallery_files.create', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:galleries,id',
            'images' => 'required|array',
            'images.*' => 'image|max:2048',
        ]);

                foreach ($request->file('images') as $image) {
            // Simpan ke storage/app/public/gallery_images
            $path = $image->store('gallery_images', 'public');

            // Salin ke public/storage/gallery_images
            $filename = basename($path);
            $publicFolder = public_path('storage/gallery_images');

            if (!file_exists($publicFolder)) {
                mkdir($publicFolder, 0777, true);
            }

            copy(
                storage_path('app/public/gallery_images/' . $filename),
                $publicFolder . '/' . $filename
            );

            // Simpan ke database
            GalleryFile::create([
                'gallery_id' => $request->gallery_id,
                'image' => $path,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }


        return redirect()->route('admin.gallery_files.index')->with('message', 'Gambar berhasil ditambahkan.');
    }

    public function edit(GalleryFile $galleryFile)
    {
        $galleries = Gallery::select('id', 'title')->get(); // ganti dari pluck
        return view('gallery_files.edit', compact('galleryFile', 'galleries'));
    }

    public function update(Request $request, GalleryFile $galleryFile)
    {
        $request->validate([
            'gallery_id' => 'required|exists:galleries,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'gallery_id' => $request->gallery_id,
            'updated_by' => Auth::id(),
        ];

        if ($request->hasFile('image')) {
    $oldFilename = basename($galleryFile->image);

    // Hapus dari storage/app/public
    if ($galleryFile->image && Storage::disk('public')->exists($galleryFile->image)) {
        Storage::disk('public')->delete($galleryFile->image);
    }

    // Hapus dari public/storage
    $oldPublicPath = public_path('storage/gallery_images/' . $oldFilename);
    if (file_exists($oldPublicPath)) {
        unlink($oldPublicPath);
    }

    // Simpan file baru ke storage
    $path = $request->file('image')->store('gallery_images', 'public');
    $data['image'] = $path;

    // Salin file ke public/storage/gallery_images
    $newFilename = basename($path);
    $publicFolder = public_path('storage/gallery_images');
    if (!file_exists($publicFolder)) {
        mkdir($publicFolder, 0777, true);
    }

    copy(
        storage_path('app/public/gallery_images/' . $newFilename),
        $publicFolder . '/' . $newFilename
    );
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


    // frontend view
    // frontend view
    public function indexFrontend()
    {
        // Ambil semua galeri beserta gambar-gambarnya
        $galleries = Gallery::with(['files'])->latest()->get();
        return view('frontend.galeri.index', compact('galleries'));
    }

    public function showFrontend(Gallery $gallery)
    {
        // Ambil satu galeri beserta semua file (gambar) yang terkait
        $gallery->load(['files']);
        return view('frontend.galeri.show', compact('gallery'));
    }
}
