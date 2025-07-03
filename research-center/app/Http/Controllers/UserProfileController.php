<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Ambil proyek yang diikuti oleh user melalui tabel collaborators
        $projectIds = $user->collaborations->pluck('project_id');

        $inProgressProjects = \App\Models\Project::whereIn('id', $projectIds)
            ->where('progress_status', 'in_progress')->get();

        $completedProjects = \App\Models\Project::whereIn('id', $projectIds)
            ->where('progress_status', 'completed')->get();

        // Ambil publikasi yang terkait dengan proyek yang diikuti
        $publications = \App\Models\Publication::whereIn('project_id', $projectIds)->get();

        return view('frontend.profil.index', compact('user', 'inProgressProjects', 'completedProjects', 'publications'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('frontend.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'user_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Proses unggah gambar
        // Proses unggah gambar
if ($request->hasFile('user_img')) {
    // Simpan file baru ke storage
    $path = $request->file('user_img')->store('user_images', 'public');
    $validated['user_img'] = $path;

    // Salin file juga ke public/storage/user_images
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


        // Update data user
        $user->update($validated);

        return redirect()->route('user.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
