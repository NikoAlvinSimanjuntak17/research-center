<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\ResearchData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Researcher;
use App\Models\Review;
use App\Models\Order;

class ResearcherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $researcher = Researcher::where('user_id', $user->id)->firstOrFail();

        // Ambil semua project yang dimiliki researcher ini (sebagai leader atau kolaborator)
        $projectAsLeader = Project::where('leader_id', $researcher->id);

        $projectAsCollaborator = Project::whereIn('id', function ($query) use ($researcher) {
            $query->select('project_id')
                ->from('collaborators')
                ->where('researcher_id', $researcher->id);
        });

        // Gabungkan dan ambil data
        $allProjects = $projectAsLeader->union($projectAsCollaborator)->get();

        // Hitung status proyek
        $totalProjects = $allProjects->count();
        $ongoingProjects = $allProjects->where('progress_status', 'in_progress')->count();
        $completedProjects = $allProjects->where('progress_status', 'completed')->count();


        // Ambil publikasi milik peneliti ini (pakai researcher_id langsung)
        $publications = Publication::where('researcher_id', $researcher->id)->get();

        // Controller
        $researcher = Researcher::where('user_id', Auth::id())->first();

        $datasetIds = ResearchData::where('researcher_id', $researcher->id)->pluck('id');
        $totalDatasets = ResearchData::where('researcher_id', $researcher->id)->count();

        // Hitung semua review untuk dataset milik researcher ini
        $totalReviews = Review::whereIn('research_data_id', $datasetIds)->count();




        // Ambil semua ID dataset milik si researcher
        $datasetIds = ResearchData::where('researcher_id', $researcher->id)->pluck('id');

        // Hitung semua order yang status-nya sukses dan membeli dataset milik researcher ini
        $totalDatasetsSold = Order::where('status', '!=', 'pending')
            ->whereJsonContains('item_type', 'research_data')
            ->get()
            ->filter(function ($order) use ($datasetIds) {
                $itemIds = json_decode($order->item_id, true); // pastikan kamu punya field item_id di orders
                $itemTypes = json_decode($order->item_type, true);
                $sold = 0;

                foreach ($itemTypes as $i => $type) {
                    if ($type === 'research_data' && in_array($itemIds[$i], $datasetIds->toArray())) {
                        return true;
                    }
                }

                return false;
            })
            ->count();

        $duplicateTitleCount = Publication::where('researcher_id', $researcher->id)
            ->select('title')
            ->groupBy('title')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();



        return view('researcher.dashboard', [
            'totalProjects' => $totalProjects,
            'ongoingProjects' => $ongoingProjects,
            'completedProjects' => $completedProjects,

            'pubOrcid' => $publications->where('source', 'orcid')->count(),
            'pubScopus' => $publications->where('source', 'scopus')->count(),
            'pubScholar' => $publications->where('source', 'googlescholar')->count(),
            'pubTsth' => $publications->where('source', 'tsth2')->count(),
            'totalPublications' => Publication::where('researcher_id', $researcher->id)
                ->select('title')
                ->distinct()
                ->count('title'),

            'totalReviews' => $totalReviews,
            'totalDatasetsSold' => $totalDatasetsSold,
            'totalDatasets' => $totalDatasets,
            'duplicateTitleCount' => $duplicateTitleCount,
        ]);
    }
}
