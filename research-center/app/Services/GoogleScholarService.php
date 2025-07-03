<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class GoogleScholarService
{
    public function fetchPublications($googleScholarId)
    {
        $url = env('GOOGLE_SCHOLAR_API_URL');
        $apiKey = env('SERPAPI_KEY');

        $response = Http::get($url, [
            'engine' => 'google_scholar_author',
            'author_id' => $googleScholarId,
            'api_key' => $apiKey
        ]);

        // Jika request gagal atau tidak sukses
        if (!$response->ok()) {
            return [];
        }

        $data = $response->json();

        // Validasi struktur data
        if (!isset($data['articles']) || !is_array($data['articles'])) {
            return [];
        }

        $publications = [];

        foreach ($data['articles'] as $item) {
            $year = Arr::get($item, 'year');
            $pubDate = $year ? $year . '-01-01' : null;
            $doi = Arr::get($item, 'doi');
            $citationId = Arr::get($item, 'citation_id');

            // Gunakan DOI jika ada, jika tidak fallback ke link Google Scholar
            $scholarUrl = $doi
                ? 'https://scholar.google.com/scholar_lookup?doi=' . urlencode($doi)
                : Arr::get($item, 'link');

            // Ambil jumlah sitasi sebagai integer
            $citedBy = is_array(Arr::get($item, 'cited_by'))
                ? Arr::get($item['cited_by'], 'value', 0)
                : (int) Arr::get($item, 'cited_by', 0);

            $publications[] = [
                'title'             => Arr::get($item, 'title', 'Untitled'),
                'year'              => $year,
                'doi'               => $doi,
                'authors'           => Arr::get($item, 'authors', 'Tidak Diketahui'),
                'journal'           => Arr::get($item, 'publication', 'Tidak Diketahui'),
                'source'            => 'Google Scholar',
                'url'               => $scholarUrl,
                'abstract'          => null, // SerpAPI tidak menyertakan abstract
                'publication_date'  => $pubDate,
                'external_id'       => $citationId ?? Str::uuid()->toString(),
                'type'              => 'journal',
                'cited_by'          => $citedBy,
                'raw_data'          => json_encode($item),
            ];
        }

        return $publications;
    }
}
