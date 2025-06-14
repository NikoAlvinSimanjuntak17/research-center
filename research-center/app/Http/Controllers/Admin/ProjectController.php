<?php

namespace App\Http\Controllers\Admin;

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
        
        return view('admin.project.index', compact('projects', 'pendingProjects'));
    }


    // // Menampilkan form tambah proyek baru
    // public function create()
    // {
    //     $researchers = Researcher::with(['user', 'department.institution'])->get();
    //     return view('admin.project.create', compact('researchers'));
    // }

    // // Simpan proyek baru
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title'         => 'required|string|max:255',
    //         'description'   => 'required|string',
    //         'open_at'       => 'required|date|after_or_equal:today',
    //         'close_at'      => 'required|date|after_or_equal:open_at',
    //         'leader_id'     => 'required|exists:researchers,id',
    //         'leader_cv'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    //         'leader_reason' => 'nullable|string|max:1000',
    //     ]);

    //     // Cek apakah sudah menjadi leader atau kolaborator di proyek lain
    //     $existingLeader = Project::where('leader_id', $request->leader_id)->first();
    //     $existingCollaborator = Collaborator::where('researcher_id', $request->leader_id)->first();

    //     if ($existingLeader || $existingCollaborator) {
    //         return redirect()->back()->withErrors([
    //             'leader_id' => 'Researcher ini sudah terlibat dalam proyek lain sebagai leader atau kolaborator.'
    //         ])->withInput();
    //     }

    //     $researcher = Researcher::with('user', 'department.institution')->findOrFail($request->leader_id);

    //     $project = Project::create([
    //         'title'             => $request->title,
    //         'description'       => $request->description,
    //         'open_at'           => Carbon::parse($request->open_at),
    //         'close_at'          => Carbon::parse($request->close_at),
    //         'created_by'        => auth()->id(),
    //         'created_by_admin'  => true,
    //         'approval_status'   => 'approved',
    //         'approved_at'       => now(),
    //         'leader_id'         => $researcher->id,
    //     ]);

    //     Collaborator::create([
    //         'project_id'    => $project->id,
    //         'user_id'       => $researcher->user_id,
    //         'researcher_id' => $researcher->id,
    //         'position'      => 'Leader',
    //         'institution'   => $researcher->department->institution->name ?? null,
    //         'department'    => $researcher->department->name ?? null,
    //         'expertise'     => $researcher->expertise,
    //         'cv'            => $request->leader_cv ? $request->leader_cv->store('cvs') : null,
    //         'reason'        => $request->leader_reason,
    //         'is_leader'     => true,
    //         'status'        => 'approved',
    //     ]);

    //     return redirect()->route('admin.project.index')->with('success', 'Proyek berhasil dibuat.');
    // }

    // // Menampilkan form edit proyek
    // public function edit($id)
    // {
    //     $project = Project::findOrFail($id);
    //     $researchers = Researcher::with('user')->get();

    //     return view('admin.project.edit', compact('project', 'researchers'));
    // }

    // // Menyimpan perubahan proyek
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title'         => 'required|string|max:255',
    //         'description'   => 'required|string',
    //         'open_at'       => 'required|date|after_or_equal:today',
    //         'close_at'      => 'required|date|after_or_equal:open_at',
    //         'leader_id'     => 'required|exists:researchers,id',
    //     ]);

    //     $project = Project::findOrFail($id);
    //     $researcher = Researcher::with('department.institution')->findOrFail($request->leader_id);

    //     $project->update([
    //         'title'     => $request->title,
    //         'description' => $request->description,
    //         'open_at'   => Carbon::parse($request->open_at),
    //         'close_at'  => Carbon::parse($request->close_at),
    //         'leader_id' => $researcher->id,
    //     ]);

    //     $existingLeader = Collaborator::where('project_id', $project->id)
    //         ->where('is_leader', true)
    //         ->first();

    //     if ($existingLeader) {
    //         $existingLeader->update([
    //             'user_id'     => $researcher->user_id,
    //             'researcher_id' => $researcher->id,
    //             'institution' => $researcher->department->institution->name ?? null,
    //             'department'  => $researcher->department->name ?? null,
    //             'expertise'   => $researcher->expertise,
    //         ]);
    //     } else {
    //         Collaborator::create([
    //             'project_id'    => $project->id,
    //             'user_id'       => $researcher->user_id,
    //             'researcher_id' => $researcher->id,
    //             'position'      => 'Leader',
    //             'institution'   => $researcher->department->institution->name ?? null,
    //             'department'    => $researcher->department->name ?? null,
    //             'expertise'     => $researcher->expertise,
    //             'cv'            => null,
    //             'reason'        => null,
    //             'is_leader'     => true,
    //             'status'        => 'approved',
    //         ]);
    //     }

    //     return redirect()->route('admin.project.index')->with('success', 'Proyek berhasil diperbarui.');
    // }

    // // Menghapus proyek
    // public function destroy($id)
    // {
    //     $project = Project::findOrFail($id);
    //     $project->delete();

    //     return redirect()->route('admin.project.index')->with('success', 'Proyek berhasil dihapus.');
    // }

    // Menampilkan kolaborator dari satu proyek
    public function showCollaborators($projectId)
    {
        $projects = Project::with('collaborators.user')->get();
        return view('admin.project.collaborators.index', compact('projects'));
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

        return view('admin.project.collaborators.show', compact('project', 'collaborator'));
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
        if (! $project->collaborators()->where('user_id', $project->created_by)->exists()) {
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

}
