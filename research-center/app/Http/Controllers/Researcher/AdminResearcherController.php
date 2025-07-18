<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Researcher;
use Illuminate\Support\Facades\Hash;
use Laratrust\Models\Role;
use Yajra\DataTables\DataTables;


class AdminResearcherController extends Controller
{
    public function index()
    {
        $researchers = Researcher::with('user')->latest()->get();
        return view('penelitian.researcher.index', compact('researchers'));
    }

    public function show($id)
    {
        $researcher = Researcher::with('user')->findOrFail($id);
        return view('penelitian.researcher.show', compact('researcher'));
    }


    public function destroy($id)
    {
        $researcher = Researcher::findOrFail($id);
        $user = $researcher->user;

        $researcher->delete();
        $user->delete();

        return redirect()->route('researcher.index')->with('success', 'Peneliti berhasil dihapus.');
    }

    public function create()
    {
        return view('penelitian.researcher.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Ensure the 'researcher' role exists (only creates if it doesn't already exist)
        $researcherRole = Role::firstOrCreate([
            'name' => 'researcher',  // This will check if the 'researcher' role exists
        ], [
            'display_name' => 'Researcher',  // Only added if the role is created
            'description' => 'Peneliti di platform', // Only added if the role is created
        ]);

        // Assign the role to the user
        \DB::table('role_user')->insert([
            'role_id' => $researcherRole->id,
            'user_id' => $user->id,
            'user_type' => \App\Models\User::class,
        ]);

        // Create the researcher profile
        Researcher::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('researcher.index')->with('success', 'Akun peneliti berhasil dibuat.');
    }

    public function dataIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Researcher::with('user')->select('id', 'user_id', 'name', 'email');
            return DataTables::of($data)->make(true);
        }
    }
}
