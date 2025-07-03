<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('admin.index', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('admin.editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
            'user_img'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Simpan gambar jika ada
if ($request->hasFile('user_img')) {
    $oldFilename = basename($user->user_img);

    // Hapus dari storage/app/public
    if ($user->user_img && Storage::disk('public')->exists($user->user_img)) {
        Storage::disk('public')->delete($user->user_img);
    }

    // Hapus dari public/storage/user_images
    $oldPublicPath = public_path('storage/user_images/' . $oldFilename);
    if (file_exists($oldPublicPath)) {
        unlink($oldPublicPath);
    }

    // Simpan file baru ke storage/app/public/user_images
    $path = $request->file('user_img')->store('user_images', 'public');
    $validated['user_img'] = $path;

    // Salin ke public/storage/user_images
    $filename = basename($path);
    $publicFolder = public_path('storage/user_images');
    if (!file_exists($publicFolder)) {
        mkdir($publicFolder, 0777, true);
    }

    copy(
        storage_path('app/public/user_images/' . $filename),
        public_path('storage/user_images/' . $filename)
    );
}


        $user->update($validated);

        return redirect()->route('admin.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
