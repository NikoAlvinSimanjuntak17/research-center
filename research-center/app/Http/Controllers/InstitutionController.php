<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution;
use Yajra\DataTables\DataTables;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::latest()->get();
        return view('institution.index', compact('institutions'));
    }

    public function create()
    {
        return view('institution.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
        ]);

        Institution::create([
            'name'    => $request->name,
            'address' => $request->address,
            'website' => $request->website,
        ]);

        return redirect()->route('admin.institutions.index')->with('success', 'Institusi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $institution = Institution::findOrFail($id);
        return view('institution.show', compact('institution'));
    }

    public function edit($id)
    {
        $institution = Institution::findOrFail($id);
        return view('institution.edit', compact('institution'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
        ]);

        $institution = Institution::findOrFail($id);
        $institution->update([
            'name'    => $request->name,
            'address' => $request->address,
            'website' => $request->website,
        ]);

        return redirect()->route('admin.institutions.index')->with('success', 'Institusi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $institution = Institution::findOrFail($id);
        $institution->delete();

        return redirect()->route('admin.institutions.index')->with('success', 'Institusi berhasil dihapus.');
    }

    public function dataIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Institution::select('id', 'name', 'address', 'website', 'created_at');
            return DataTables::of($data)->make(true);
        }
    }
}
