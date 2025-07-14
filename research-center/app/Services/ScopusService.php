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
        $this->apiKey = config('services.scopus.api_key');
    }

    /**
     * Validasi apakah Scopus ID milik peneliti berdasarkan nama
     */
    public function validateOwner(string $scopusId, string $name): bool
    {
        $url = config('services.scopus.api_url') . "/content/author?author_id=$scopusId";

        $response = Http::withHeaders([
            'X-ELS-APIKey' => $this->apiKey,
            'Accept' => 'application/json',
        ])->get($url);

        if (!$response->successful()) {
            Log::warning("Gagal validasi Scopus ID: $scopusId");
            return false;
        }

        $data = $response->json();
        $author = data_get($data, 'author-retrieval-response.0.author-profile.preferred-name');

        if (!$author) return false;

        $scopusName = trim(($author['given-name'] ?? '') . ' ' . ($author['surname'] ?? ''));
        return strcasecmp($scopusName, $name) === 0;
    }

    public function isValidScopusId(string $scopusId, string $name = null): bool
    {
        $response = Http::withHeaders([
            'X-ELS-APIKey' => $this->apiKey,
            'Accept' => 'application/json',
        ])
        ->get(config('services.scopus.api_url') . "/content/author?author_id=$scopusId");

        if ($response->failed()) return false;

        if ($name) {
            $author = data_get($response->json(), 'author-retrieval-response.0.author-profile.preferred-name');
            $fullName = trim(($author['given-name'] ?? '') . ' ' . ($author['surname'] ?? ''));
            return stripos($fullName, $name) !== false;
        }

        return true;
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
        $response = Http::withHeaders([
            'X-ELS-APIKey' => $this->apiKey,
            'Accept' => 'application/json',
        ])->get($this->baseUrl, [
            'query' => 'AU-ID(' . $scopusId . ')'
        ]);

        if (!$response->successful()) {
            Log::error('Failed to fetch publications from Scopus for ID: ' . $scopusId, [
                'response' => $response->body(),
            ]);
            return [];
        }

        $entries = $response->json()['search-results']['entry'] ?? [];

        return collect($entries)->map(function ($entry) {
            $scopusIdRaw = $entry['dc:identifier'] ?? null;
            $scopusId = str_replace('SCOPUS_ID:', '', $scopusIdRaw);

            $citationCount = $this->getCitationCount($scopusId);

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
