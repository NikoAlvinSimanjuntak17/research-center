<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResearchFacility;
use Illuminate\Support\Facades\Storage;

class ResearchFacilityController extends Controller
{
    public function index()
    {
        $facilities = ResearchFacility::all();
        return view('penelitian.fasilitas.index', compact('facilities'));
    }

    public function create()
    {
        return view('penelitian.fasilitas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }

        ResearchFacility::create($data);
        return redirect()->route('admin.research-facility.index')->with('message', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $facility = ResearchFacility::findOrFail($id); // ambil datanya dulu
        return view('penelitian.fasilitas.edit', compact('facility')); // kirim ke view
    }


    public function update(Request $request, ResearchFacility $research_facility)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($research_facility->image);
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }

        $research_facility->update($data);
        return redirect()->route('admin.research-facility.index')->with('message', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(ResearchFacility $research_facility)
    {
        // Hapus gambar jika ada dan file-nya memang ada di storage
        if ($research_facility->image && Storage::disk('public')->exists($research_facility->image)) {
            Storage::disk('public')->delete($research_facility->image);
        }

        // Hapus data dari database
        $research_facility->delete();

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('admin.research-facility.index')
            ->with('message', 'Fasilitas berhasil dihapus.');
    }
    
    public function show(ResearchFacility $research_facility)
    {
        return view('penelitian.fasilitas.show', compact('research_facility'));
    }

    // frontend
    public function indexFrontend()
    {
        // Ambil semua data fasilitas riset
        $facilities = ResearchFacility::all();

        // Kirim ke view
        return view('frontend.fasilitas-penelitian.index', compact('facilities'));
    }

    public function view($id)
    {
        $facility = ResearchFacility::findOrFail($id);
        $fasilitas_lain = ResearchFacility::where('id', '!=', $id)->latest()->take(5)->get();

        return view('frontend.fasilitas-penelitian.view', compact('facility', 'fasilitas_lain'));
    }
}
