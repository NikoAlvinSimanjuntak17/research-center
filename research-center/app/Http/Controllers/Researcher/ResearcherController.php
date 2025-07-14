<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Researcher;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\ORCIDService;
use App\Services\ScopusService;
use App\Services\GoogleScholarService;
use Illuminate\Validation\ValidationException;

class ResearcherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = auth()->user();
        $researcher = $user->researcher;

        $totalPublications = $researcher->publications()->count();

        $totalProjects = $researcher->projects()->count(); // Anda bisa pastikan ada relasi `projects()`

        $projectsInProgress = $researcher->projects()
            ->where('progress_status', 'in_progress')->count();

        $projectsCompleted = $researcher->projects()
            ->where('progress_status', 'completed')->count();

        $collaboratorsPerProject = $researcher->projects()
            ->withCount('collaborators') // Pastikan ada relasi `collaborators()`
            ->get();

        return view('researcher.dashboard', compact(
            'researcher',
            'totalPublications',
            'totalProjects',
            'projectsInProgress',
            'projectsCompleted',
            'collaboratorsPerProject'
        ));
    }

    public function editProfile()
    {
        $user = $this->ensureResearcher();
        $researcher = $user->researcher;
        $institutions = Institution::all();
        $departments = Department::with('institution')->get();

        return view('researcher.editprofile', compact('user', 'researcher', 'institutions', 'departments'));
    }



    public function updateProfile(Request $request)
    {
        $user = $this->ensureResearcher();

        $validated = $request->validate([
            'orcid_id' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'googlescholar_id' => 'nullable|string|max:255',
            'garuda_id' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'department_id' => 'nullable|exists:departments,id',
            'nip' => 'nullable|string|max:50',
            'bachelor_degree' => 'nullable|string|max:255',
            'master_degree' => 'nullable|string|max:255',
            'doctor_degree' => 'nullable|string|max:255',
            'experiences' => 'nullable|string',
            'citation_count' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        // Validasi ID ke layanan masing-masing
        try {
            if ($request->orcid_id) {
                $orcidService = new ORCIDService();
                if (!$orcidService->validateOwner($request->orcid_id, $user->name)) {
                    throw ValidationException::withMessages(['orcid_id' => 'ORCID ID tidak valid atau bukan milik Anda.']);
                }
            }

            if ($request->googlescholar_id) {
                $scholarService = new GoogleScholarService();
                if (!$scholarService->validateOwner($request->googlescholar_id, $user->name)) {
                    throw ValidationException::withMessages(['googlescholar_id' => 'Google Scholar ID tidak valid atau bukan milik Anda.']);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memvalidasi ID: ' . $e->getMessage()]);
        }

        $researcher = $user->researcher ?? new Researcher(['user_id' => $user->id]);

        if ($request->hasFile('image')) {
            if ($researcher->image) {
                Storage::disk('public')->delete($researcher->image);
            }
            $researcher->image = $request->file('image')->store('researchers', 'public');
        }

        $researcher->fill([
            'orcid_id' => $request->orcid_id,
            'scopus_id' => $request->scopus_id,
            'googlescholar_id' => $request->googlescholar_id,
            'garuda_id' => $request->garuda_id,
            'department_id' => $request->department_id,
            'nip' => $request->nip,
            'bachelor_degree' => $request->bachelor_degree,
            'master_degree' => $request->master_degree,
            'doctor_degree' => $request->doctor_degree,
            'experiences' => $request->experiences,
            'citation_count' => $request->citation_count,
            'active' => $request->active ?? true,
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'updated_by' => $user->id,
        ])->save();

        return redirect()->route('researcher.profile.show')->with('message', 'Profil berhasil diperbarui.');
    }


    public function showProfile()
    {
        $user = $this->ensureResearcher();
        $researcher = $user->researcher;

        return view('researcher.showprofile', compact('user', 'researcher'));
    }

    protected function ensureResearcher()
    {
        $user = Auth::user();
        if (!$user->researcher) {
            $user->researcher()->create([
                'user_id' => $user->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'active' => true,
            ]);
        }
        return $user;
    }
}
