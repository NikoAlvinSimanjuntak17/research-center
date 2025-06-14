<?php

namespace App\Http\Controllers\Researchers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Researcher;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResearcherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    private function ensureResearcher()
    {
        $user = Auth::user();
        if (!$user->hasRole('researcher')) {
            abort(403, 'Akses ditolak');
        }
        return $user;
    }

    public function index()
    {
        $this->ensureResearcher();
        return view('researchers.dashboard');
    }

    public function editProfile()
    {
        $user = $this->ensureResearcher();
        $researcher = $user->researcher;
        $institutions = Institution::all();
        $departments = Department::with('institution')->get();

        return view('researchers.editprofile', compact('user', 'researcher', 'institutions', 'departments'));
    }

public function updateProfile(Request $request)
{
    $user = $this->ensureResearcher();

    $validated = $request->validate([
        'orcid_id' => 'nullable|string|max:255',
        'scopus_id' => 'nullable|string|max:255',
        'garuda_id' => 'nullable|string|max:255',
        'googlescholar_id' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'department_id' => 'nullable|exists:departments,id',
        'nip' => 'nullable|string|max:255',
        'bachelor_degree' => 'nullable|string|max:255',
        'master_degree' => 'nullable|string|max:255',
        'doctor_degree' => 'nullable|string|max:255',
        'experiences' => 'nullable|string',
    ]);

    try {
        $researcher = $user->researcher ?? new Researcher(['user_id' => $user->id]);

if ($request->hasFile('image')) {
    // Hapus gambar lama jika ada
    if ($researcher->image && file_exists(public_path($researcher->image))) {
        unlink(public_path($researcher->image));
    }

    $file = $request->file('image');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $destination = public_path('storage/photos');

    // Buat folder jika belum ada
    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }

    // Pindahkan file ke public/storage/photos
    $file->move($destination, $fileName);

    // Simpan path relatif ke DB
    $researcher->image = 'photos/' . $fileName;
}


        $researcher->fill([
            'orcid_id' => $request->orcid_id,
            'scopus_id' => $request->scopus_id,
            'garuda_id' => $request->garuda_id,
            'googlescholar_id' => $request->googlescholar_id,
            'department_id' => $request->department_id,
            'nip' => $request->nip,
            'bachelor_degree' => $request->bachelor_degree,
            'master_degree' => $request->master_degree,
            'doctor_degree' => $request->doctor_degree,
            'experiences' => $request->experiences,
        ])->save();
    } catch (\Exception $e) {
        dd([
            'message' => 'Terjadi kesalahan saat update profil',
            'error' => $e->getMessage(),
            'request_data' => $request->all(),
            'validated_data' => $validated,
            'user_id' => $user->id,
        ]);
    }

    return redirect()->route('researchers.dashboard')->with('message', 'Profil berhasil diperbarui.');
}


    public function showProfile()
    {
        $user = $this->ensureResearcher();
        $researcher = $user->researcher;

        return view('researchers.profile', compact('user', 'researcher'));
    }
}
