<?php

namespace App\Http\Controllers\Researchers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Project;
use App\Models\Researcher;

class DashboardController extends Controller
{
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

    return view('researchers.dashboard', compact(
        'researcher',
        'totalPublications',
        'totalProjects',
        'projectsInProgress',
        'projectsCompleted',
        'collaboratorsPerProject'
    ));
}

}
