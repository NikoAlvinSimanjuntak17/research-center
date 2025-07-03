<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaboratorController extends Controller
{
    public function index()
    {
        // Ambil semua proyek yang punya kolaborator
        $projects = \App\Models\Project::with('collaborators.user')
            ->whereHas('collaborators')
            ->orderByDesc('created_at')
            ->get();

        return view('proyek.collaborators.index', compact('projects'));
    }

    public function show($id)
    {
        $collaborator = Collaborator::with(['user', 'project'])->findOrFail($id);
        return view('proyek.collaborators.show', compact('collaborator'));
    }

    public function approve($id)
    {
        $collaborator = Collaborator::findOrFail($id);
        $collaborator->update(['status' => 'approved']);

        return back()->with('success', 'Kolaborator disetujui.');
    }

    public function reject($id)
    {
        $collaborator = Collaborator::findOrFail($id);
        $collaborator->update(['status' => 'rejected']);

        return back()->with('success', 'Kolaborator ditolak.');
    }

    public function makeLeader($id)
    {
        $collaborator = Collaborator::findOrFail($id);

        if ($collaborator->status !== 'approved') {
            return back()->with('error', 'Hanya kolaborator yang disetujui yang bisa jadi leader.');
        }

        Collaborator::where('project_id', $collaborator->project_id)
            ->update(['is_leader' => false]);

        $collaborator->update(['is_leader' => true]);

        return back()->with('success', 'Kolaborator dijadikan leader.');
    }


    public function downloadCV($id)
    {
        $collaborator = Collaborator::findOrFail($id);
        if ($collaborator->cv && Storage::exists($collaborator->cv)) {
            return Storage::download($collaborator->cv);
        }

        return back()->with('error', 'CV tidak tersedia.');
    }
}