<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Publication;
use App\Models\Project;
use App\Models\Collaborator;
use App\Models\User;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Ambil semua data dari relasi collaborators
        $collaborators = $user->collaborators()->with('project')->get();

        // Filter berdasarkan status
        $approvedCollaborators = $collaborators->where('status', 'approved');
        $pendingCollaborators  = $collaborators->where('status', 'pending');
        $rejectedCollaborators = $collaborators->where('status', 'rejected');

        // Ambil project_id dari yang disetujui
        $approvedProjectIds = $approvedCollaborators->pluck('project_id');

        // Ambil proyek berdasarkan status progress
        $inProgressProjects = \App\Models\Project::whereIn('id', $approvedProjectIds)
            ->where('progress_status', 'in_progress')
            ->get();

        $completedProjects = \App\Models\Project::whereIn('id', $approvedProjectIds)
            ->where('progress_status', 'completed')
            ->get();

        // Ambil publikasi dari proyek yang di-approve
        $publications = \App\Models\Publication::whereIn('project_id', $approvedProjectIds)->get();

        return view('frontend.profil.index', compact(
            'user',
            'approvedCollaborators',
            'pendingCollaborators',
            'rejectedCollaborators',
            'inProgressProjects',
            'completedProjects',
            'publications'
        ));
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
