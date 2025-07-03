<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnershipController extends Controller
{
    public function index()
    {
        $partnerships = Partnership::all();
        return view('kerjasama.index', compact('partnerships'));
    }

    public function create()
    {
        return view('kerjasama.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/partnerships
            $path = $request->file('image')->store('partnerships', 'public');
            $data['image'] = $path;

            // Salin file ke public/partnerships
            $filename = basename($path);
            $destination = public_path('storage/partnerships');

            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            copy(
                storage_path('app/public/partnerships/' . $filename),
                $destination . '/' . $filename
            );
        }


        Partnership::create($data);
        return redirect()->route('admin.partnership.index')->with('message', 'Kerja sama berhasil ditambahkan.');
    }

    public function edit(Partnership $partnership)
    {
        return view('kerjasama.edit', compact('partnership'));
    }

    public function update(Request $request, Partnership $partnership)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/partnerships
            $path = $request->file('image')->store('partnerships', 'public');
            $data['image'] = $path;

            // Salin ke public/partnerships
            $filename = basename($path);
            $destination = public_path('storage/partnerships');

            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            copy(
                storage_path('app/public/partnerships/' . $filename),
                $destination . '/' . $filename
            );
        }


        $partnership->update($data);
        return redirect()->route('admin.partnership.index')->with('message', 'Kerja sama berhasil diperbarui.');
    }

    public function destroy(Partnership $partnership)
    {
        Storage::disk('public')->delete($partnership->image);
        $partnership->delete();
        return redirect()->route('admin.partnership.index')->with('message', 'Kerja sama berhasil dihapus.');
    }

    // frontend
    public function indexFrontend()
    {
        // Ambil semua data kerja sama
        $partnerships = Partnership::all();

        // Kirim ke view frontend
        return view('frontend.kerja-sama.index', compact('partnerships'));
    }

    public function view($id)
    {
        $partnership = Partnership::findOrFail($id);
        $partnerships_lain = Partnership::where('id', '!=', $partnership->id)->latest()->take(4)->get();

        return view('frontend.kerja-sama.view', compact('partnership', 'partnerships_lain'));
    }
}
