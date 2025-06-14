<?php

namespace App\Http\Controllers\Admin;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstitutionController extends Controller
{
    public function __construct()
    {
        // Middleware role admin, memastikan hanya admin yang bisa mengakses
        $this->middleware('role:admin');
    }

    public function index()
    {
        $institutions = Institution::all();
        return view('admin.institutions.index', compact('institutions'));
    }

    public function create()
    {
        return view('admin.institutions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
        ]);

        Institution::create($validated);
        return redirect()->route('admin.institutions.index')->with('message', 'Institution created successfully');
    }

    public function edit(Institution $institution)
    {
        return view('admin.institutions.edit', compact('institution'));
    }

    public function update(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
        ]);

        $institution->update($validated);
        return redirect()->route('admin.institutions.index')->with('message', 'Institution updated successfully');
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();
        return redirect()->route('admin.institutions.index')->with('message', 'Institution deleted successfully');
    }
}
