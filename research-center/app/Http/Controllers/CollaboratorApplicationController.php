<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CollaboratorApplicationController extends Controller
{
    /**
     * Menampilkan semua proyek terbuka yang sudah disetujui.
     */
    public function index()
{
    $projects = Project::whereDate('close_at', '>', Carbon::today())
        ->where('approval_status', 'approved')
        ->orderBy('open_at', 'desc')
        ->paginate(6);

    $closedProjects = Project::whereDate('close_at', '<=', Carbon::today())
        ->orderBy('close_at', 'desc')
        ->take(5) // batasi jika ingin tampil sedikit
        ->get();

    return view('projects.index', compact('projects', 'closedProjects'));
}


    /**
     * Menampilkan form pendaftaran untuk kolaborator.
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);

        // Validasi status waktu & keikutsertaan user
        if (now()->toDateString() > $project->close_at->toDateString()) {
            return redirect()->back()->with('error', 'Pendaftaran untuk proyek ini telah ditutup.');
        }

        if (Collaborator::where('project_id', $projectId)->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Kamu sudah mendaftar untuk proyek ini.');
        }

        if (Collaborator::where('user_id', Auth::id())->whereHas('project', function ($query) {
            $query->where('status', 'in progress');
        })->exists()) {
            return redirect()->back()->with('error', 'Kamu masih memiliki proyek yang sedang berjalan.');
        }

        return view('projects.formdaftar', compact('project'));
    }

    /**
     * Menyimpan data pendaftaran kolaborator ke dalam database.
     */
    public function store(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

        // Validasi tanggal
        if (now()->gt($project->close_at)) {
            return redirect()->back()->with('error', 'Pendaftaran untuk proyek ini telah ditutup.');
        }

        // Cek duplikasi pendaftaran
        if (Collaborator::where('project_id', $projectId)->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Kamu sudah mendaftar untuk proyek ini.');
        }

        $validated = $request->validate([
            'position'    => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'department'  => 'nullable|string|max:255',
            'expertise'   => 'nullable|string|max:255',
            'cv'          => 'nullable|file|mimes:pdf|max:2048',
            'reason'      => 'nullable|string|max:2000',
        ]);

        // Simpan file CV jika ada
        $cvPath = $request->hasFile('cv') ? $request->file('cv')->store('cvs') : null;

        Collaborator::create([
            'project_id'  => $projectId,
            'user_id'     => Auth::id(),
            'position'    => $validated['position'],
            'institution' => $validated['institution'],
            'department'  => $validated['department'],
            'expertise'   => $validated['expertise'],
            'cv'          => $cvPath,
            'reason'      => $validated['reason'],
            'is_leader'   => false,
            'status'      => 'pending',
        ]);

        return redirect()->route('collaborator.projects')->with('success', 'Pendaftaran berhasil dikirim.');
    }
}
