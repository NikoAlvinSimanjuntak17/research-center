<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class GoogleScholarService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.key');
        $this->baseUrl = config('services.serpapi.google_scholar_url');
    }

    public function validateOwner(string $scholarId, string $name): bool
    {
        try {
            $response = Http::get(config('services.serpapi.google_scholar_url'), [
                'engine' => 'google_scholar_author',
                'author_id' => $scholarId,
                'api_key' => config('services.serpapi.key'),
            ]);

            if ($response->failed()) return false;

            $profileName = data_get($response->json(), 'author.name');
            if (!$profileName) return false;

            $profileName = strtolower($profileName);
            $name = strtolower($name);

            // Cocokkan apakah nama user mengandung bagian dari nama profile
            return Str::contains($profileName, explode(' ', $name)[0]) // nama depan
                || Str::contains($profileName, explode(' ', $name)[1] ?? ''); // nama belakang
        } catch (\Exception $e) {
            Log::error("Validasi Google Scholar gagal: " . $e->getMessage());
            return false;
        }
    }

    public function fetchPublications(string $scholarId): array
    {
        $response = Http::get($this->baseUrl, [
            'api_key'    => $this->apiKey,
            'engine'     => 'google_scholar_author',
            'author_id'  => $scholarId,
        ]);

        if (!$response->successful()) {
            Log::error('Gagal mengambil publikasi dari Google Scholar', ['id' => $scholarId]);
            return [];
        }

        $data = $response->json();

        if (!isset($data['articles']) || !is_array($data['articles'])) {
            return [];
        }

        return collect($data['articles'])->map(function ($item) {
            $year = Arr::get($item, 'year');
            $pubDate = $year ? $year . '-01-01' : null;
            $doi = Arr::get($item, 'doi');
            $citationId = Arr::get($item, 'citation_id');

            $scholarUrl = $doi
                ? 'https://scholar.google.com/scholar_lookup?doi=' . urlencode($doi)
                : Arr::get($item, 'link');

            $citedBy = is_array(Arr::get($item, 'cited_by'))
                ? Arr::get($item['cited_by'], 'value', 0)
                : (int) Arr::get($item, 'cited_by', 0);

            return [
                'title'             => Arr::get($item, 'title', 'Untitled'),
                'year'              => $year,
                'doi'               => $doi,
                'authors'           => Arr::get($item, 'authors', 'Tidak Diketahui'),
                'journal'           => Arr::get($item, 'publication', 'Tidak Diketahui'),
                'source'            => 'Google Scholar',
                'url'               => $scholarUrl,
                'abstract'          => null,
                'publication_date'  => $pubDate,
                'external_id'       => $citationId ?? Str::uuid()->toString(),
                'type'              => 'journal',
                'cited_by'          => $citedBy,
                'raw_data'          => json_encode($item),
            ];
        })->toArray();
    }
}
