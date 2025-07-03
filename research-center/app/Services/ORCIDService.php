<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ORCIDService
{
    protected $baseUrl = 'https://pub.orcid.org/v3.0/';

    public function getCitationCountByDOI(string $doi): ?int
    {
        try {
            $response = Http::get("https://api.crossref.org/works/" . urlencode($doi));
            if ($response->successful()) {
                return $response->json('message["is-referenced-by-count"]') ?? null;
            }
        } catch (\Exception $e) {
            \Log::error("Gagal ambil citation count dari Crossref: {$e->getMessage()}");
        }
        
        return null;
    }


    public function fetchPublications($orcidId)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get($this->baseUrl . $orcidId . '/works');
    
        if (!$response->successful()) {
            \Log::error('Failed to fetch ORCID data for ID: ' . $orcidId);
            return [];
        }
    
        $data = $response->json();
        $publications = [];
    
        if (!isset($data['group']) || empty($data['group'])) {
            return $publications;
        }
    
        foreach ($data['group'] as $group) {
            $workSummary = $group['work-summary'][0] ?? null;
            if (!$workSummary || !isset($workSummary['put-code'])) continue;
    
            $putCode = $workSummary['put-code'];
    
            // Ambil detail work untuk mendapatkan author
            $detailResponse = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($this->baseUrl . $orcidId . '/work/' . $putCode);
    
            if (!$detailResponse->successful()) {
                \Log::warning("Gagal mengambil detail publikasi ORCID: {$orcidId} / {$putCode}");
                continue;
            }
    
            $detail = $detailResponse->json();
    
            $title = data_get($detail, 'title.title.value', 'Untitled');
            $year  = data_get($detail, 'publication-date.year.value');
            $month = data_get($detail, 'publication-date.month.value', '01');
            $day   = data_get($detail, 'publication-date.day.value', '01');
            $pubDate = $year ? "{$year}-{$month}-{$day}" : null;
    
            $doi = collect(data_get($detail, 'external-ids.external-id', []))
                ->first(fn($id) => strtolower($id['external-id-type'] ?? '') === 'doi')['external-id-value'] ?? null;
    
            $authors = collect(data_get($detail, 'contributors.contributor', []))
                ->map(fn($c) => data_get($c, 'credit-name.value') ?? data_get($c, 'contributor-orcid.path'))
                ->filter()
                ->implode(', ');
            
            $citationCount = $doi ? $this->getCitationCountByDOI($doi) : 0;
    
            $publications[] = [
                'title' => $title,
                'year' => $year,
                'doi' => $doi,
                'source' => 'ORCID',
                'authors' => $authors,
                'journal' => null,
                'url' => $doi ? 'https://doi.org/' . $doi : null,
                'abstract' => null,
                'publication_date' => $pubDate,
                'external_id' => $putCode,
                'type' => data_get($detail, 'type', 'Unknown'),
                'citation_count' => $citationCount,
                'raw_data' => json_encode($detail),
            ];
        }
    
        return $publications;
    }    
}
