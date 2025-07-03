<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $departments = Department::with('institution')->get();
        return view('department.index', compact('departments'));
    }

    public function create()
    {
        $institutions = Institution::all();
        return view('department.create', compact('institutions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        Department::create($validated);
        return redirect()->route('admin.department.index')->with('message', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $institutions = Institution::all();
        return view('department.edit', compact('department', 'institutions'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        $department->update($validated);
        return redirect()->route('admin.department.index')->with('message', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.department.index')->with('message', 'Department deleted successfully.');
    }
}
