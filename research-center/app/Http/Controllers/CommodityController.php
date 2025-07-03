<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommodityController extends Controller
{
    public function index()
    {
        $commodities = Commodity::all()->groupBy('key');
        return view('penelitian.komoditas.index', compact('commodities'));
    }

    public function create()
    {
        $keys = Commodity::select('key')->distinct()->pluck('key');
        return view('penelitian.komoditas.create', compact('keys'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/commodities
            $path = $request->file('image')->store('commodities', 'public');
            $data['image'] = $path;

            // Salin ke public/commodities (jangan hapus yang lama)
            $filename = basename($path);
            $destination = public_path('storage/commodities');

            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            copy(
                storage_path('app/public/commodities/' . $filename),
                $destination . '/' . $filename
            );
        }



        Commodity::create($data);
        return redirect()->route('admin.commodity.index')->with('message', 'Komoditas berhasil ditambahkan.');
    }

    public function edit(Commodity $commodity)
    {
        $keys = Commodity::select('key')->distinct()->pluck('key');
        return view('penelitian.komoditas.edit', compact('commodity', 'keys'));
    }

    public function update(Request $request, Commodity $commodity)
    {
        $data = $request->validate([
            'key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama hanya jika memang ada
            if ($commodity->image && Storage::disk('public')->exists($commodity->image)) {
                Storage::disk('public')->delete($commodity->image);
            }

            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('commodities', 'public');

            // Copy ke public/commodities
            $filename = basename($data['image']);
            $destination = public_path('storage/commodities');

            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            copy(
                storage_path('app/public/commodities/' . $filename),
                $destination . '/' . $filename
            );
        }

        $commodity->update($data);

        return redirect()->route('admin.commodity.index')->with('message', 'Komoditas berhasil diperbarui.');
    }


    public function destroy(Commodity $commodity)
    {
        if ($commodity->image && Storage::disk('public')->exists($commodity->image)) {
            Storage::disk('public')->delete($commodity->image);
        }

        $commodity->delete();

        return redirect()->route('admin.commodity.index')->with('message', 'Komoditas berhasil dihapus.');
    }

    // frontend
    public function indexFrontend()
    {
        // Ambil semua data komoditas
        $komoditas = Commodity::all();
        // Kirim ke view
        return view('frontend.komoditas.index', compact('komoditas'));
    }

    public function view($id)
    {
        $komoditas = Commodity::findOrFail($id);
        $komoditas_lain = Commodity::where('id', '!=', $id)->latest()->take(6)->get();
        return view('frontend.komoditas.view', compact('komoditas', 'komoditas_lain'));
    }
}
