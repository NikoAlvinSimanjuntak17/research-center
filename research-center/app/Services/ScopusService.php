<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScopusService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.elsevier.com/content/search/scopus';

    public function __construct()
    {
        $this->apiKey = env('SCOPUS_API_KEY'); // API Key from .env
    }
    
    protected function getCitationCount($scopusId)
    {
        $url = "https://api.elsevier.com/content/abstract/scopus_id/{$scopusId}";
        
        $response = Http::withHeaders([
            'X-ELS-APIKey' => $this->apiKey,
            'Accept' => 'application/json',
            ])->get($url);
            
            if (!$response->successful()) {
                Log::warning("Gagal mengambil citation count untuk Scopus ID: {$scopusId}");
                return null;
            }
            
            return data_get($response->json(), 'abstracts-retrieval-response.coredata.citedby-count');
    }

    public function fetchPublications($scopusId)
    {
        // Send GET request to Scopus API
        $response = Http::withHeaders([
            'X-ELS-APIKey' => $this->apiKey,
            'Accept' => 'application/json',
        ])->get($this->baseUrl, [
            'query' => 'AU-ID(' . $scopusId . ')'
        ]);

        // Check if the response is successful
        if (!$response->successful()) {
            Log::error('Failed to fetch publications from Scopus for ID: ' . $scopusId, [
                'response' => $response->body(),
            ]);
            return [];
        }

        // Parse response JSON
        $entries = $response->json()['search-results']['entry'] ?? [];

        return collect($entries)->map(function ($entry) {
            $scopusIdRaw = $entry['dc:identifier'] ?? null;
            $scopusId = str_replace('SCOPUS_ID:', '', $scopusIdRaw); // bersih ID Scopus
        
            // Ambil citation count
            $citationCount = $this->getCitationCount($scopusId); // <= akses method via $this
        
            return [
                'title' => $entry['dc:title'] ?? 'Untitled',
                'year' => Carbon::parse($entry['prism:coverDate'] ?? '')->year ?? null,
                'publication_date' => $entry['prism:coverDate'] ?? null,
                'doi' => $entry['prism:doi'] ?? null,
                'source' => 'Scopus',
                'authors' => $entry['dc:creator'] ?? 'Unknown',
                'journal' => $entry['prism:publicationName'] ?? 'Unknown Journal',
                'url' => $entry['link'][0]['@href'] ?? null,
                'abstract' => $entry['dc:description'] ?? 'No abstract available',
                'external_id' => $scopusIdRaw,
                'type' => $entry['prism:aggregationType'] ?? 'Unknown',
                'citation_count' => $citationCount,
                'raw_data' => json_encode($entry),
            ];
        })->toArray();
    }
}
