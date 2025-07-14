<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Publication;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class ResearcherProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('created_by', auth()->id())->get();
        return view('researcher.projects.index', compact('projects'));
    }

    public function create()
    {
        $researcherId = auth()->user()->researcher->id;

        $hasInProgress = Project::where('leader_id', $researcherId)
            ->where('approval_status', 'approved')
            ->where('progress_status', 'in_progress')
            ->exists();

        if ($hasInProgress) {
            return redirect()->route('researcher.projects.index')
                ->with('error', 'Anda masih memiliki proyek yang sedang berjalan. Tidak bisa mengajukan proyek baru.');
        }

        return view('researcher.projects.create');
    }

    public function store(Request $request)
    {
        $researcherId = auth()->user()->researcher->id;

        $hasInProgress = Project::where('leader_id', $researcherId)
            ->where('approval_status', 'approved')
            ->where('progress_status', 'in_progress')
            ->exists();

        if ($hasInProgress) {
            return redirect()->route('researcher.projects.index')
                ->with('error', 'Anda masih memiliki proyek yang sedang berjalan. Tidak bisa mengajukan proyek baru.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'open_at' => 'required|date|after_or_equal:today',
            'close_at' => 'required|date|after:open_at',
        ]);

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'open_at' => Carbon::parse($request->open_at),
            'close_at' => Carbon::parse($request->close_at),
            'approval_status' => 'pending',
            'created_by' => auth()->id(),
            'created_by_admin' => false,
            'leader_id' => $researcherId,
        ]);

        return redirect()->route('researcher.projects.index')->with('success', 'Pengajuan proyek berhasil. Menunggu persetujuan admin.');
    }

    public function show($id)
    {
        $project = Project::where('created_by', auth()->id())->findOrFail($id);
        return view('researcher.projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::where('created_by', auth()->id())
            ->where('approval_status', 'pending')
            ->findOrFail($id);

        return view('researcher.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'open_at' => 'required|date|after_or_equal:today',
            'close_at' => 'required|date|after_or_equal:open_at',
        ]);

        $project = Project::where('created_by', auth()->id())
            ->where('approval_status', 'pending')
            ->findOrFail($id);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'open_at' => Carbon::parse($request->open_at),
            'close_at' => Carbon::parse($request->close_at),
        ]);

        return redirect()->route('researcher.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $project = Project::where('created_by', auth()->id())
            ->where('approval_status', 'pending')
            ->findOrFail($id);

        $project->delete();

        return redirect()->route('researcher.projects.index')->with('success', 'Pengajuan proyek berhasil dihapus.');
    }


    // Tampilkan form submit publikasi untuk proyek yang masih in_progress
    public function submitPublication($id)
    {
        $project = Project::where('created_by', auth()->id())
            ->where('progress_status', 'in_progress')
            ->findOrFail($id);

        return view('researcher.projects.formsubmit', compact('project'));
    }

    public function storePublication(Request $request, $id)
    {
        $project = Project::where('created_by', auth()->id())
            ->where('progress_status', 'in_progress') // harus masih in_progress
            ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'journal' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'doi' => 'nullable|string|max:255',
        ]);

        $inputTitle = trim(strtolower($request->title));
        $doi = trim($request->doi);

        // Jika DOI diisi, validasi judul sesuai dengan metadata dari Crossref
        if (!empty($doi)) {
            try {
                $response = Http::timeout(10)->get("https://api.crossref.org/works/" . urlencode($doi));

                if ($response->failed() || !isset($response['message']['title'][0])) {
                    return back()->withInput()->withErrors(['doi' => 'DOI tidak valid atau tidak ditemukan.']);
                }

                $doiTitle = trim(strtolower($response['message']['title'][0]));

                if ($inputTitle !== $doiTitle) {
                    return back()->withInput()->withErrors([
                        'title' => 'Judul tidak sesuai dengan metadata dari DOI.',
                        'doi' => 'Judul dari DOI: "' . $response['message']['title'][0] . '"',
                    ]);
                }
            } catch (\Exception $e) {
                return back()->withInput()->withErrors([
                    'doi' => 'Gagal mengambil data dari Crossref. Periksa koneksi atau format DOI.',
                ]);
            }
        }

        // Ambil collaborators yang statusnya approved dan load relasi user
        $collaborators = $project->collaborators()->where('status', 'approved')->with('user')->get();

        // Ambil nama user dari relasi user
        $authors = $collaborators->map(function ($collaborator) {
            return $collaborator->user->name ?? 'Unknown';
        })->toArray();

        $publication = Publication::create([
            'project_id' => $project->id,
            'researcher_id' => auth()->user()->researcher->id,
            'title' => $request->title,
            'journal' => $request->journal,
            'doi' => $request->doi,
            'publication_date' => $request->publication_date,
            'source' => 'TSTH2',
            'authors' => json_encode($authors),
        ]);

        // Insert juga ke pivot table
        $publication->researchers()->attach(auth()->user()->researcher->id);

        // Update status proyek menjadi completed
        $project->progress_status = 'completed';
        $project->save();

        return redirect()->route('researcher.projects.index')
            ->with('success', 'Publikasi berhasil ditambahkan dan proyek ditandai selesai.');
    }
}
