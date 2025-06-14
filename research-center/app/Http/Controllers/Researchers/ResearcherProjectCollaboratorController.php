<?php

namespace App\Http\Controllers\Researchers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Collaborator;
use Illuminate\Http\Request;

class ResearcherProjectCollaboratorController extends Controller
{
    // Tampilkan daftar kolaborator semua proyek milik peneliti yang sedang login
    public function index()
    {
        // Ambil semua proyek yang dibuat oleh peneliti ini, sekaligus eager load kolaborator + user-nya
        $projects = Project::with('collaborators.user')
            ->where('created_by', auth()->id())
            ->get();

        return view('researchers.projects.collaborators.index', compact('projects'));
    }

    // Tampilkan detail kolaborator di proyek tertentu
    public function show($projectId, $userId)
    {
        $project = Project::where('created_by', auth()->id())->findOrFail($projectId);

        $collaborator = $project->collaborators()->where('user_id', $userId)->firstOrFail();

        return view('researchers.projects.collaborators.show', compact('project', 'collaborator'));
    }

    // Update status kolaborator (approve/reject)
    public function updateCollaboratorStatus(Request $request, $projectId, $userId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $project = Project::where('created_by', auth()->id())->findOrFail($projectId);

        $collaborator = $project->collaborators()->where('user_id', $userId)->firstOrFail();

        $collaborator->status = $request->status;
        $collaborator->save();

        return redirect()->route('researchers.projects.collaborators.index')
            ->with('success', "Status kolaborator berhasil diubah menjadi {$request->status}.");
    }

    // Hapus kolaborator dari proyek
    public function removeCollaborator($projectId, $userId)
    {
        $project = Project::where('created_by', auth()->id())->findOrFail($projectId);

        $collaborator = $project->collaborators()->where('user_id', $userId)->firstOrFail();

        $collaborator->delete();

        return redirect()->route('researchers.projects.collaborators.index')
            ->with('success', 'Kolaborator berhasil dihapus.');
    }

    // Menampilkan Project untuk mendaftar sebagai kolabporator di halaman peneliti
}
