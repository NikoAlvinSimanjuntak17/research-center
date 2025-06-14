<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari query string
        $year = $request->input('year');
        $type = $request->input('type'); // jurnal / prosiding

        // Query dasar
        $query = Publication::query();

        // Filter berdasarkan tahun
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        // Filter berdasarkan jenis
        if ($type) {
            $query->where('type', $type); // pastikan ada kolom `type` di tabel publications
        }

        // Ambil data publikasi yang sudah difilter
        $publications = $query->latest()->paginate(10);

        // Ambil daftar tahun unik dari tabel untuk keperluan filter
        $years = Publication::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.publications.index', compact('publications', 'years', 'year', 'type'));
    }

    public function show($id)
{
    $publication = Publication::with('researchers.user')->findOrFail($id);
    return view('admin.publications.show', compact('publication'));
}

}
