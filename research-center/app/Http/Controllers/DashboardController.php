<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Researcher;

class DashboardController extends Controller
{
    public function index()
    {
        $year = Carbon::now()->year;

        $orders = Order::whereYear('created_at', $year)
            ->where('status', '!=', 'pending')
            ->get();

        $monthlySales = collect(range(1, 12))->map(function ($month) use ($orders) {
            return $orders->filter(function ($order) use ($month) {
                return Carbon::parse($order->created_at)->month === $month
                    && collect(json_decode($order->item_type))->contains('research_data');
            })->reduce(function ($carry, $order) {
                $prices = json_decode($order->totalprice, true);
                $types = json_decode($order->item_type, true);

                foreach ($types as $index => $type) {
                    if ($type === 'research_data') {
                        $carry += (int) ($prices[$index] ?? 0);
                    }
                }
                return $carry;
            }, 0);
        });

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalDatasetsSold' => Order::whereJsonContains('item_type', 'research_data')
                ->where('status', '!=', 'pending')
                ->count(),
            'totalOrders' => Order::count(),
            'totalReviews' => Review::count(),
            'chartLabels' => $chartLabels,
            'chartData' => $monthlySales->toArray(),

            // Tambahan Statistik
            'totalProjects' => Project::count(),
            'ongoingProjects' => Project::where('progress_status', 'in_progress')->count(),
            'completedProjects' => Project::where('progress_status', 'completed')->count(),

            'totalPublications' => Publication::count(),
            'pubOrcid' => Publication::where('source', 'orcid')->count(),
            'pubScopus' => Publication::where('source', 'scopus')->count(),
            'pubScholar' => Publication::where('source', 'googlescholar')->count(),
            'pubTsth' => Publication::where('source', 'tsth2')->count(),

            'totalResearchers' => Researcher::count(),
        ]);
    }


}
