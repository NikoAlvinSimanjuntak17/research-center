<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\OrganizationStructure;

class OrganizationStructureController extends Controller
{
    /**
     * Display a listing of the organization structures.
     */
    public function index()
    {
        $organizationStructures = OrganizationStructure::all();
        return view('admin.organization.index', compact('organizationStructures'));
    }

    /**
     * Show the form for creating a new organization structure.
     */
    public function create()
    {
        return view('admin.organization.create');
    }

    /**
     * Store a newly created organization structure in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        'description' => 'required|string', // Validasi deskripsi
    ]);

    // Simpan foto
    $path = $request->file('photo')->store('organization', 'public');

    // Simpan data ke database
    OrganizationStructure::create([
        'photo' => $path,
        'description' => $request->input('description'),
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('admin.organization.index')->with('success', 'Struktur organisasi berhasil ditambahkan.');
}


    /**
     * Display the specified organization structure.
     */
    public function show(OrganizationStructure $organizationStructure)
    {
        return view('admin.organization.show', compact('organizationStructure'));
    }

    /**
     * Show the form for editing the specified organization structure.
     */
    public function edit(OrganizationStructure $organizationStructure)
    {
        return view('admin.organization.edit', compact('organizationStructure'));
    }

    /**
     * Update the specified organization structure in storage.
     */
    public function update(Request $request, OrganizationStructure $organizationStructure)
    {
        // Validasi input
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);

        // Jika ada file baru, hapus file lama lalu simpan yang baru
        if ($request->hasFile('photo')) {
            if ($organizationStructure->photo) {
                Storage::disk('public')->delete($organizationStructure->photo);
            }

            $organizationStructure->photo = $request->file('photo')->store('organization', 'public');
        }

        // Update deskripsi
        $organizationStructure->description = $request->input('description');
        $organizationStructure->save();

        return redirect()->route('admin.organization.index')->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified organization structure from storage.
     */
    public function destroy(OrganizationStructure $organizationStructure)
    {
        // Hapus file foto jika ada
        if ($organizationStructure->photo) {
            Storage::disk('public')->delete($organizationStructure->photo);
        }

        // Hapus data dari database
        $organizationStructure->delete();

        return redirect()->route('admin.organization.index')->with('success', 'Struktur organisasi berhasil dihapus.');
    }
}
