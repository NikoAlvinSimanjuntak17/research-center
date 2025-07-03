<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Collaborator;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{
    // Menampilkan daftar proyek
    public function index()
    {
        // Eager load relasi yang diperlukan untuk menghindari N+1 query
        // Menggunakan eager loading untuk mengoptimalkan query
        $withRelations = ['leader.user', 'collaborators.user'];

        // Proyek yang sudah disetujui atau ditolak
        $projects = Project::with(['leader.user', 'collaborators.user'])
            ->whereIn('approval_status', ['approved', 'rejected'])
            ->orderByDesc('created_at')
            ->get();

        $pendingProjects = Project::with($withRelations)
            ->pending()
            ->get();

        return view('proyek.index', compact('projects', 'pendingProjects'));
    }
    // Menampilkan kolaborator dari satu proyek
    public function showCollaborators()
    {
        $projects = Project::with('collaborators.user')->get();
        return view('proyek.collaborators.index', compact('projects'));
    }

    // Menyetujui atau menolak kolaborator
    public function updateCollaboratorStatus(Request $request, $projectId, $userId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $collaborator = Collaborator::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $collaborator->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status kolaborator berhasil diperbarui.');
    }

    // Menghapus kolaborator
    public function removeCollaborator($projectId, $userId)
    {
        $collaborator = Collaborator::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $collaborator->delete();

        return redirect()->back()->with('success', 'Kolaborator berhasil dihapus.');
    }

    // Menampilkan detail kolaborator
    public function showCollaboratorDetail(Project $project, User $user)
    {
        $collaborator = Collaborator::where('project_id', $project->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$collaborator) {
            return redirect()->back()->with('error', 'Kolaborator tidak ditemukan.');
        }

        return view('proyek.collaborators.show', compact('project', 'collaborator'));
    }

    // Menyetujui proyek
    public function approve($id)
    {
        $project = Project::findOrFail($id);

        if ($project->approval_status === 'approved') {
            return back()->with('error', 'Proyek sudah disetujui.');
        }

        $project->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
            'progress_status' => 'in_progress',
        ]);

        // Tambahkan peneliti sebagai collaborator (jika belum)
        if (!$project->collaborators()->where('user_id', $project->created_by)->exists()) {
            $project->collaborators()->create([
                'user_id' => $project->created_by,
                'researcher_id' => $project->leader_id,
                'position' => 'Project Leader',
                'status' => 'approved',
                'is_leader' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Proyek disetujui.');
    }

    // Menolak proyek
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->reason, // Ambil dari textarea name="reason"
        ]);

        return redirect()->back()->with('success', 'Proyek ditolak.');
    }

    public function pendingCount($projectId)
    {
        $project = Project::with('collaborators')->findOrFail($projectId);
        $pendingCount = $project->collaborators->where('status', 'pending')->count();

        return response()->json(['count' => $pendingCount]);
    }

    // frontend publik
    // Menampilkan daftar proyek untuk guest
    public function indexfrontend()
    {
        $projects = Project::whereDate('close_at', '>', Carbon::today())
            ->where('approval_status', 'approved')
            ->orderBy('open_at', 'desc')
            ->paginate(6);

        $closedProjects = Project::whereDate('close_at', '<=', Carbon::today())
            ->orderBy('close_at', 'desc')
            ->take(5) // batasi jika ingin tampil sedikit
            ->get();

        return view('frontend.proyek.index', compact('projects', 'closedProjects'));
    }

    // Menampilkan detail proyek untuk guest
    public function show($id)
    {
        $project = Project::with('creator')->findOrFail($id);
        $isClosed = $project->close_at ? now()->gt($project->close_at) : false;
        $hasApplied = false;

        if (auth()->check()) {
            $hasApplied = Collaborator::where('project_id', $project->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        $recentProjects = Project::where('id', '!=', $project->id)
            ->where('approval_status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.proyek.view', compact('project', 'isClosed', 'hasApplied', 'recentProjects'));
    }

}
