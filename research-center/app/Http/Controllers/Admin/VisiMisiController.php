<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisionMission;

class VisiMisiController extends Controller
{
    public function index()
    {
        $visi = VisionMission::where('type', 'visi')->first();
        $misi = VisionMission::where('type', 'misi')->first();

        return view('admin.visimisi.index', compact('visi', 'misi'));
    }

    public function create()
    {
        return view('admin.visimisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => 'required',
            'misi' => 'required',
        ]);
    
        VisionMission::create([
            'type' => 'visi',
            'content' => $request->visi,
        ]);
    
        VisionMission::create([
            'type' => 'misi',
            'content' => $request->misi,
        ]);
    
        return redirect()->route('admin.visimisi.index')->with('success', 'Visi dan Misi berhasil ditambahkan.');
    }
    
    public function edit()
    {
        $visi = VisionMission::where('type', 'visi')->first();
        $misi = VisionMission::where('type', 'misi')->first();

        return view('admin.visimisi.edit', compact('visi', 'misi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'visi' => 'required',
            'misi' => 'required',
        ]);
    
        // Update Visi
        VisionMission::updateOrCreate(
            ['type' => 'visi'],
            ['content' => $request->visi]
        );
    
        // Update Misi
        VisionMission::updateOrCreate(
            ['type' => 'misi'],
            ['content' => $request->misi]
        );
    
        return redirect()->route('admin.visimisi.index')->with('success', 'Visi dan Misi berhasil diperbarui.');
    }
    

    public function destroy($type)
    {
        if (!in_array($type, ['visi', 'misi'])) {
            abort(404);
        }

        VisionMission::where('type', $type)->delete();

        return redirect()->route('admin.visimisi.index')->with('success', ucfirst($type) . ' berhasil dihapus.');
    }
}
