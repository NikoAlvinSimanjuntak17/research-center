<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Researcher;
use App\Services\ORCIDService;
use App\Services\ScopusService;
use App\Services\GarudaService;
use App\Services\GoogleScholarService;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

class PublicationController extends Controller
{
    protected $orcidService;
    protected $scopusService;
    protected $garudaService;
    protected $googleScholarService;

    public function __construct(
        ORCIDService $orcidService,
        ScopusService $scopusService,
        GarudaService $garudaService,
        GoogleScholarService $googleScholarService
    ) {
        $this->orcidService = $orcidService;
        $this->scopusService = $scopusService;
        $this->garudaService = $garudaService;
        $this->googleScholarService = $googleScholarService;
    }

    public function syncPublications($researcherId)
    {
        $researcher = Researcher::findOrFail($researcherId);
        $allPublications = [];

        try {
            if ($researcher->orcid_id) {
                $orcidPublications = $this->orcidService->fetchPublications($researcher->orcid_id);
                $allPublications = array_merge($allPublications, $orcidPublications);
            }

            if ($researcher->scopus_id) {
                $scopusPublications = $this->scopusService->fetchPublications($researcher->scopus_id);
                $allPublications = array_merge($allPublications, $scopusPublications);
            }

            if ($researcher->garuda_id) {
                $garudaPublications = $this->garudaService->fetchPublications($researcher->garuda_id);
                $allPublications = array_merge($allPublications, $garudaPublications);
            }

            if ($researcher->googlescholar_id) {
                $scholarPublications = $this->googleScholarService->fetchPublications($researcher->googlescholar_id);
                $allPublications = array_merge($allPublications, $scholarPublications);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat pengambilan data publikasi.',
                'error' => $e->getMessage(),
            ], 500);
        }

        if (empty($allPublications)) {
            return response()->json([
                'message' => 'Tidak ada publikasi yang ditemukan untuk peneliti ini.',
            ], 404);
        }

        return response()->json([
            'message' => 'Data publikasi berhasil diambil.',
            'publications' => $allPublications,
            'jumlah' => count($allPublications),
        ]);
    }

    public function index()
    {
        $researcher = auth()->user()->researcher;

        $sources = [
            'orcid' => [$researcher->orcid_id, $this->orcidService],
            'scopus' => [$researcher->scopus_id, $this->scopusService],
            'garuda' => [$researcher->garuda_id, $this->garudaService],
            'googlescholar' => [$researcher->googlescholar_id, $this->googleScholarService],
        ];

        // menampilkan publikasi yang di upload dari sistem dengan nama sumber TSTH2
        $sources['TSTH2'] = [null, null]; // Tambahkan sumber TSTH2 tanpa ID
    
        $publicationsBySource = [];

        foreach ($sources as $source => [$id, $service]) {
            // Ambil publikasi dari relasi many-to-many + filter source
            $publications = $researcher->publications()->where('source', $source)->get();

            if ($publications->isEmpty() && $id) {
                try {
                    $fetched = $service->fetchPublications($id);

                    foreach ($fetched as $pub) {
                        // Coba cari existing publication
                        $publication = Publication::firstOrCreate(
                            [
                                'researcher_id' => $researcher->id,
                                'external_id' => $pub['external_id'] ?? null,
                                'title' => $pub['title'] ?? '',
                                'abstract' => $pub['abstract'] ?? null,
                                'type' => $pub['type'] ?? null,
                                'source' => $source,
                            ],
                            [
                                'authors' => $pub['authors'] ?? null,
                                'doi' => $pub['doi'] ?? null,
                                'journal' => $pub['journal'] ?? null,
                                'year' => $pub['year'] ?? null,
                                'publication_date' => $pub['publication_date'] ?? null,
                                'url' => $pub['url'] ?? null,
                                'raw_data' => $pub['raw_data'] ?? null,
                                'citation_count' => $pub['citation_count'] ?? 0,
                            ]
                        );

                        // Hubungkan dengan peneliti jika belum terhubung
                        if (!$researcher->publications->contains($publication->id)) {
                            $researcher->publications()->attach($publication->id);
                        }
                    }

                    $publications = $researcher->publications()->where('source', $source)->get();
                } catch (\Exception $e) {
                    \Log::error("Gagal sinkronisasi dari $source: " . $e->getMessage());
                    continue;
                }
            }

            $publicationsBySource[$source] = $publications;
        }

        return view('researchers.publication', [
            'orcidPublications' => $publicationsBySource['orcid'] ?? [],
            'scopusPublications' => $publicationsBySource['scopus'] ?? [],
            'garudaPublications' => $publicationsBySource['garuda'] ?? [],
            'googleScholarPublications' => $publicationsBySource['googlescholar'] ?? [],
            'tsth2Publications' => $publicationsBySource['TSTH2'] ?? [],
        ]);
    }
}
