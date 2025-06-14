<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Researcher;
use Illuminate\Support\Facades\Hash;
use Laratrust\Models\Role;


class AdminResearcherController extends Controller
{
    public function index()
    {
        $researchers = Researcher::with('user')->latest()->get();
        return view('admin.researchers.index', compact('researchers'));
    }

    public function show($id)
    {
        $researcher = Researcher::with('user')->findOrFail($id);
        return view('admin.researchers.show', compact('researcher'));
    }


    public function destroy($id)
    {
        $researcher = Researcher::findOrFail($id);
        $user = $researcher->user;

        $researcher->delete();
        $user->delete();

        return redirect()->route('admin.researchers.index')->with('success', 'Peneliti berhasil dihapus.');
    }

    public function create()
    {
        return view('admin.researchers.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Ensure the 'researcher' role exists (only creates if it doesn't already exist)
        $researcherRole = Role::firstOrCreate([
            'name' => 'researcher',  // This will check if the 'researcher' role exists
        ], [
            'display_name' => 'Researcher',  // Only added if the role is created
            'description'  => 'Peneliti di platform', // Only added if the role is created
        ]);
    
        // Assign the role to the user
        $user->addRole($researcherRole);
    
        // Create the researcher profile
        Researcher::create([
            'user_id'   => $user->id,
            'name' => $request->name,
            'email'     => $request->email,
        ]);
    
        return redirect()->route('admin.researchers.index')->with('success', 'Akun peneliti berhasil dibuat.');
    }
}
