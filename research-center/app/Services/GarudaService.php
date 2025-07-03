<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GarudaService
{
    public function fetchPublications($garudaId)
    {
        $url = env('GARUDA_API_URL') . "?author=" . urlencode($garudaId);

        $response = Http::get($url);
        if (!$response->ok()) return [];

        $data = $response->json();
        if (!is_array($data)) return [];

        $publications = [];

        foreach ($data as $item) {
            // Normalisasi tahun jadi tanggal (misalnya: 2022 -> 2022-01-01)
            $year = $item['year'] ?? null;
            $pubDate = $year ? $year . '-01-01' : null;

            $doi = $item['doi'] ?? null;
            $url = $item['url'] ?? ($doi ? 'https://doi.org/' . $doi : null);

            $publications[] = [
                'title' => $item['title'] ?? 'Untitled',
                'year' => $year,
                'doi' => $doi,
                'authors' => $item['authors'] ?? null,
                'journal' => $item['journal'] ?? null,
                'source' => 'Garuda',
                'url' => $url,
                'abstract' => $item['abstract'] ?? null,
                'publication_date' => $pubDate,
                'external_id' => $item['id'] ?? Str::uuid()->toString(),
                'type' => $item['type'] ?? 'journal',
                'raw_data' => json_encode($item),
            ];
        }

        return $publications;
    }
}
