<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::orderBy('key')->orderBy('title')->get();
        return view('admin.profiles.index', compact('profiles'));
    }

    public function create()
    {
        $existingKeys = Profile::select('key')->distinct()->pluck('key');
        return view('admin.profiles.create', compact('existingKeys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
        }

        Profile::create([
            'key' => $request->key,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'active' => $request->active ?? 1,
        ]);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile berhasil dibuat.');
    }

    public function edit(Profile $profile)
    {
        $existingKeys = Profile::select('key')->distinct()->pluck('key');
        return view('admin.profiles.edit', compact('profile', 'existingKeys'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Hapus gambar lama jika upload baru
        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $profile->image = $request->file('image')->store('profiles', 'public');
        }

        $profile->update([
            'key' => $request->key,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $profile->image,
            'updated_by' => Auth::id(),
            'active' => $request->active ?? 1,
        ]);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile berhasil diperbarui.');
    }

    public function destroy(Profile $profile)
    {
        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }

        $profile->delete();

        return redirect()->route('admin.profiles.index')->with('success', 'Profile berhasil dihapus.');
    }
}
