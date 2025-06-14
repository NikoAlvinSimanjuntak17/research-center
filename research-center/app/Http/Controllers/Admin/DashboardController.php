<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Researcher;
use App\Models\Publication;
use App\Models\Project;
use App\Models\Collaborator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            // Statistik dasar
            'totalResearchers' => Researcher::count(),
            'totalPublications' => Publication::count(),
            'totalProjects' => Project::count(),
            'collaboratorCount' => Collaborator::count(),

            // Proyek berdasarkan status progress
            'completedProjects' => Project::where('progress_status', 'completed')->count(),
            'inProgressProjects' => Project::where('progress_status', 'in_progress')->count(),

            // Publikasi terbaru
            'latestPublications' => Publication::latest()->take(5)->get(),

            // Jumlah publikasi per tahun
            'publicationsPerYear' => Publication::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                ->groupBy('year')->orderBy('year')->get(),

            // Peneliti baru per bulan (tahun berjalan)
            'newResearchersPerMonth' => Researcher::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')->get(),

            // Jumlah publikasi berdasarkan sumber (source)
            'publicationsBySource' => Publication::select('source', DB::raw('COUNT(*) as total'))
                ->groupBy('source')->get(),

            // Total seluruh citation (dari citation_count)
            'totalCitations' => Publication::sum('citation_count'),
        ]);
    }
}
