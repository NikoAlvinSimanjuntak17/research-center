<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Collaborator;   
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuestProjectController extends Controller
{
    // Menampilkan daftar proyek untuk guest
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

    // Menampilkan detail proyek untuk guest
    public function show($id)
    {
        
        $project = Project::with('creator')->findOrFail($id);
        $isClosed = $project->close_at ? now()->gt($project->close_at) : false;
        $createdAt = Carbon::parse($project->created_at);
        
        $hasApplied = false;
        if (auth()->check()) {
            $hasApplied = Collaborator::where('project_id', $project->id)
            ->where('user_id', auth()->id())
            ->exists();
        }
        
        return view('projects.show', compact('project', 'isClosed', 'hasApplied', 'createdAt'));
    }
}
