<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Researcher;
use App\Models\Institution;
use App\Models\Department;


class UserPublicationController extends Controller
{
    
    public function index()
    {
        $publications = Publication::latest()->paginate(5); // Semua publikasi
        // Mengambil publikasi dari berbagai sumber
        
        // Menentukan source dan DOI (jika ada)
        foreach ($publications as $pub) {
            // Tentukan sumber publikasi dan DOI (misalnya berdasarkan data API atau manual)
            if ($pub->is_from_scopus) {
                $pub->source = 'scopus';
                $pub->doi = $pub->scopus_doi;
            } elseif ($pub->is_from_orcid) {
                $pub->source = 'orcid';
                $pub->doi = $pub->orcid_doi;
            } elseif ($pub->is_from_google_scholar) {
                $pub->source = 'googlescholar';
            }
        }

        // Menghitung jumlah publication berdasarkan sumber
        $orcidCount = Publication::where('source', 'orcid')->count();
        $scopusCount = Publication::where('source', 'scopus')->count();
        $googleScholarCount = Publication::where('source', 'googlescholar')->count();
        $garudaCount = Publication::where('source', 'garuda')->count();
        $totalPublications = $orcidCount + $scopusCount + $googleScholarCount + $garudaCount;
        
        return view('jurnal', compact('publications', 
            'orcidCount',
            'scopusCount',
            'googleScholarCount',
            'garudaCount',
            'totalPublications'
        ));
    }
    
    public function showByResearcher(Researcher $researcher)
    {
        // Ambil berdasarkan relasi dan sumber
        $orcidPublications = $researcher->publications()->where('source', 'orcid')->get();
        $scopusPublications = $researcher->publications()->where('source', 'scopus')->get();
        $googleScholarPublications = $researcher->publications()->where('source', 'googlescholar')->get();
        $garudaPublications = $researcher->publications()->where('source', 'garuda')->get();
        
        return view('jurnalbysearch', compact(
            'researcher',
            'orcidPublications',
            'scopusPublications',
            'googleScholarPublications',
            'garudaPublications'
        ));
    }
    
    public function fetchPublications()
    {
        return view('jurnal', [
            'orcidPublications' => Publication::where('source', 'orcid')->get(),
            'scopusPublications' => Publication::where('source', 'scopus')->get(),
            'garudaPublications' => Publication::where('source', 'garuda')->get(),
            'googleScholarPublications' => Publication::where('source', 'googlescholar')->get(),
        ]);
    }
    
    // Cari berdasarkan nama user yang berelasi dengan researcher
    public function search(Request $request, Researcher $researcher)
    {

        // Ambil berdasarkan relasi dan sumber
        $orcidPublications = $researcher->publications()->where('source', 'orcid')->get();
        $scopusPublications = $researcher->publications()->where('source', 'scopus')->get();
        $googleScholarPublications = $researcher->publications()->where('source', 'googlescholar')->get();
        $garudaPublications = $researcher->publications()->where('source', 'garuda')->get();
        $query = $request->input('query');
        
        // menghitung jumlah publication
        $orcidCount = $orcidPublications->count();
        $scopusCount = $scopusPublications->count();
        $googleScholarCount = $googleScholarPublications->count();
        $garudaCount = $garudaPublications->count();
        $totalCountpublications = $orcidCount + $scopusCount + $googleScholarCount + $garudaCount;

        // Mengambil peneliti berdasarkan nama user yang berelasi
        
        
        $researchers = Researcher::whereHas('user', function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })->get();
        
        // Kalau hanya satu peneliti yang ditemukan, langsung redirect ke publikasi dia
        if ($researchers->count() === 1) {
            return redirect()->route('publications.byresearcher', $researchers->first()->id);
        }
        
        // Kalau lebih dari satu, tampilkan daftar pilihan
        return view('jurnalbysearch', compact('researchers', 
            'query',
            'orcidPublications',
            'scopusPublications',
            'googleScholarPublications',
            'garudaPublications', 
            'orcidCount',
            'scopusCount',
            'googleScholarCount',
            'garudaCount',
            'totalCountpublications'));
        
    }
   
    public function listResearchers()
    {
        $researchers = Researcher::with(['user', 'department.institution'])->paginate(10); // Menampilkan 10 per halaman
        return view('researchers', compact('researchers'));
    }

    public function showResearcherDetail(Researcher $researcher)
    {
        $researcher->load('user', 'department.institution');
        return view('jurnalbysearch', compact('researcher'));
    }

    public function showAffiliations()
    {
        $institutions = Institution::with('departments')->get();
        return view('affiliation', compact('institutions'));
    }
    
    public function showInstitutionDetail(Institution $institution)
    {
        // Ambil semua researcher dari semua departemen
        $researchers = $institution->departments->flatMap(function ($dept) {
            return $dept->researchers;
        });
        
        // Kumpulkan publikasi per source
        $orcidPublications = collect();
        $scopusPublications = collect();
        $googleScholarPublications = collect();
        
        foreach ($researchers as $researcher) {
            $orcidPublications = $orcidPublications->merge(
                $researcher->publications()->where('source', 'orcid')->get()
            );
            $scopusPublications = $scopusPublications->merge(
                $researcher->publications()->where('source', 'scopus')->get()
            );
            $googleScholarPublications = $googleScholarPublications->merge(
                $researcher->publications()->where('source', 'googlescholar')->get()
            );
        }
        
        $departments = $institution->departments()->with('researchers.publications')->get();
        
        $totalDepartments = $departments->count();
        
        // Hitung total publikasi dari semua peneliti di semua departemen
        $totalPublications = 0;
        foreach ($departments as $dept) {
            foreach ($dept->researchers as $researcher) {
                $totalPublications += $researcher->publications->count();
            }
        }
        
        return view('detailaffiliation', compact(
            'institution',
            'departments',
            'totalDepartments',
            'totalPublications',
            'orcidPublications',
            'scopusPublications',
            'googleScholarPublications'
        ));
    }
    public function showdept($id)
    {
        $institution = Institution::with('departments')->findOrFail($id);
        $departments = $institution->departments;

        return view('department', compact('institution', 'departments'));
    }

    public function showDepartmentDetail(Department $department)
    {
        // Ambil semua peneliti beserta publikasi mereka (eager load agar tidak N+1)
        $researchers = $department->researchers()->with('publications')->get();
        
        // Kumpulkan publikasi berdasarkan source
        $orcidPublications = collect();
        $scopusPublications = collect();
        $googleScholarPublications = collect();
        
        foreach ($researchers as $researcher) {
            $orcidPublications = $orcidPublications->merge(
                $researcher->publications->where('source', 'orcid')
            );
            $scopusPublications = $scopusPublications->merge(
                $researcher->publications->where('source', 'scopus')
            );
            $googleScholarPublications = $googleScholarPublications->merge(
                $researcher->publications->where('source', 'googlescholar')
            );
        }
        
        return view('detaildept', compact(
            'department',
            'orcidPublications',
            'scopusPublications',
            'googleScholarPublications'
        ));
    }
    
}