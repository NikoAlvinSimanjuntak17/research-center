<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class JoinProjectController extends Controller
{
    /**
     * Tampilkan daftar proyek yang bisa diikuti dan yang sudah diikuti.
     */
    public function index()
    {
        $userId = auth()->id();

        // Ambil semua kolaborasi user (dengan data proyek dan status kolaborator)
        $collaborations = \App\Models\Collaborator::with('project.owner')
            ->where('user_id', $userId)
            ->whereHas('project', function ($query) use ($userId) {
                $query->where('created_by', '!=', $userId);
            })
            ->get();

        // Kelompokkan berdasarkan status
        $joinedProjects = [
            'approved' => [],
            'pending' => [],
            'rejected' => [],
        ];

        foreach ($collaborations as $collab) {
            $project = $collab->project;
            if ($project) {
                $project->pivot = (object)[
                    'status' => $collab->status,
                    'position' => $collab->position,
                    'reason' => $collab->reason ?? null,
                ];
                $joinedProjects[$collab->status][] = $project;
            }
        }

        // Proyek yang bisa diikuti
        $availableProjects = Project::with('owner')
            ->open()
            ->where('created_by', '!=', $userId)
            ->whereDoesntHave('collaborators', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        return view('researcher.projects.join.index', [
            'joinedProjects' => $joinedProjects,
            'availableProjects' => $availableProjects,
            'canJoin' => true,
        ]);
    }


    /**
     * Proses permintaan join ke sebuah proyek.
     */
    public function join(Project $project)
    {
        $user = auth()->user();
        $researcher = $user->researcher;

        // Cek apakah user sedang jadi leader proyek in_progress
        $hasInProgressAsLeader = Project::where('created_by', $user->id)
            ->where('progress_status', 'in_progress')
            ->exists();

        // Cek apakah user sedang jadi kolaborator aktif (approved) di proyek in_progress
        $hasInProgressAsCollaborator = Project::whereHas('collaborators', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', 'approved');
        })->where('progress_status', 'in_progress')->exists();

        if ($hasInProgressAsLeader || $hasInProgressAsCollaborator) {
            return back()->with('error', 'Kamu tidak bisa bergabung ke proyek lain karena masih memiliki proyek yang sedang berjalan.');
        }

        // Cegah join ke proyek sendiri
        if ($project->created_by === $user->id) {
            return back()->with('error', 'Kamu tidak bisa mendaftar ke proyekmu sendiri.');
        }

        // Cegah join ganda
        if ($project->collaborators()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Kamu sudah mendaftar ke proyek ini.');
        }

        // Tambah sebagai kolaborator dengan status pending
        $project->collaborators()->create([
            'user_id' => $user->id,
            'researcher_id' => $researcher->id ?? null,
            'position' => $researcher->position ?? 'researcher',
            'institution' => $researcher->institution ?? null,
            'department' => $researcher->department ?? null,
            'expertise' => $researcher->expertise ?? null,
            'cv' => $researcher->cv ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan bergabung berhasil dikirim.');
    }

    /**
     * (Opsional) Batalkan permintaan bergabung atau keluar dari proyek.
     */
    public function leave(Project $project)
    {
        $user = auth()->user();

        $collaboration = $project->collaborators()->where('user_id', $user->id)->first();

        if (!$collaboration) {
            return back()->with('error', 'Kamu tidak tergabung dalam proyek ini.');
        }

        // Jika status masih pending, bisa dibatalkan
        if ($collaboration->status === 'pending' || $collaboration->status === 'approved') {
            $collaboration->delete();
            return back()->with('success', 'Berhasil keluar dari proyek.');
        }

        return back()->with('error', 'Tidak dapat keluar dari proyek ini.');
    }
}
