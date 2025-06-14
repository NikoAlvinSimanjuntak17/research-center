<?php

namespace App\Services;

use App\Models\Publication;
use App\Models\Researcher;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PublicationSyncService
{
    private function getCitationCountByDOI(string $doi): int
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->get("https://api.crossref.org/works/" . urlencode($doi));

            if ($response->successful()) {
                return data_get($response->json(), 'message.is-referenced-by-count', 0);
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal ambil sitasi Crossref untuk DOI {$doi}: {$e->getMessage()}");
        }

        return 0;
    }

    private function getWorkDetail(string $orcidId, string $putCode)
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->timeout(10)
                ->get("https://pub.orcid.org/v3.0/{$orcidId}/work/{$putCode}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("Gagal ambil detail ORCID work: Status {$response->status()}");
        } catch (\Throwable $e) {
            Log::error("Exception ambil detail ORCID work: {$e->getMessage()}");
        }

        return null;
    }

    public function syncFromOrcid(Researcher $researcher)
    {
        if (!$researcher->orcid_id) {
            Log::info("Peneliti ID {$researcher->id} tidak memiliki ORCID ID.");
            return;
        }

        $url = "https://pub.orcid.org/v3.0/{$researcher->orcid_id}/works";

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])->timeout(10)->get($url);

            if ($response->failed()) {
                Log::warning("Gagal ambil data ORCID: {$url} - Status: {$response->status()}");
                return;
            }

            $groups = $response->json()['group'] ?? [];

            foreach ($groups as $item) {
                $summary = $item['work-summary'][0] ?? null;
                if (!$summary || !isset($summary['put-code'])) continue;

                $putCode = (string) $summary['put-code'];
                $detail = $this->getWorkDetail($researcher->orcid_id, $putCode);
                if (!$detail) continue;

                $title = data_get($detail, 'title.title.value', 'No Title');
                $year = data_get($detail, 'publication-date.year.value');
                $month = data_get($detail, 'publication-date.month.value', '01');
                $day = data_get($detail, 'publication-date.day.value', '01');

                $publicationDate = $year ? Carbon::createFromDate($year, $month, $day)->toDateString() : null;

                $doi = collect(data_get($detail, 'external-ids.external-id', []))
                    ->first(fn($id) => strtolower($id['external-id-type'] ?? '') === 'doi')['external-id-value'] ?? null;

                $authors = collect(data_get($detail, 'contributors.contributor', []))
                    ->map(fn($c) => data_get($c, 'credit-name.value') ?? data_get($c, 'contributor-orcid.path'))
                    ->filter()
                    ->implode(', ');

                $citationCount = $doi ? $this->getCitationCountByDOI($doi) : 0;

                Publication::updateOrCreate(
                    ['external_id' => $putCode, 'source' => 'orcid'],
                    [
                        'researcher_id'    => $researcher->id,
                        'title'            => $title,
                        'publication_date' => $publicationDate,
                        'doi'              => $doi,
                        'authors'          => $authors,
                        'citation_count'   => $citationCount,
                        'raw_data'         => json_encode($detail),
                        'type'             => 'journal',
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error("Exception sinkronisasi ORCID: {$e->getMessage()}");
        }
    }

    public function syncFromScopus(Researcher $researcher)
    {
        if (!$researcher->scopus_id) return;

        $apiKey = env('SCOPUS_API_KEY');
        $url = "https://api.elsevier.com/content/search/scopus?query=AU-ID({$researcher->scopus_id})&apiKey={$apiKey}";

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])->get($url);

            if ($response->failed()) {
                Log::warning("Gagal ambil data Scopus: {$url} - Status: {$response->status()}");
                return;
            }

            $entries = $response->json()['search-results']['entry'] ?? [];

            foreach ($entries as $entry) {
                $externalId = $entry['dc:identifier'] ?? null;
                if (!$externalId) continue;

                $doi = $entry['prism:doi'] ?? null;
                $citationCount = $doi ? $this->getCitationCountByDOI($doi) : ($entry['citedby-count'] ?? 0);

                Publication::updateOrCreate(
                    ['external_id' => $externalId, 'source' => 'scopus'],
                    [
                        'researcher_id'    => $researcher->id,
                        'title'            => $entry['dc:title'] ?? '-',
                        'journal'          => $entry['prism:publicationName'] ?? null,
                        'doi'              => $doi,
                        'publication_date' => $entry['prism:coverDate'] ?? null,
                        'authors'          => $entry['dc:creator'] ?? null,
                        'citation_count'   => $citationCount,
                        'raw_data'         => json_encode($entry),
                        'type'             => null,
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error("Exception sinkronisasi Scopus: {$e->getMessage()}");
        }
    }

    public function syncFromGaruda(Researcher $researcher)
    {
        if (!$researcher->garuda_id) return;

        $url = "https://garuda.kemdikbud.go.id/api/publications/{$researcher->garuda_id}";

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])->get($url);

            if ($response->failed()) {
                Log::warning("Gagal ambil data Garuda: {$url} - Status: {$response->status()}");
                return;
            }

            $data = $response->json()['publications'] ?? [];

            foreach ($data as $pub) {
                $externalId = $pub['id'] ?? null;
                if (!$externalId) continue;

                Publication::updateOrCreate(
                    ['external_id' => $externalId, 'source' => 'garuda'],
                    [
                        'researcher_id'    => $researcher->id,
                        'title'            => $pub['title'] ?? '-',
                        'journal'          => $pub['journal'] ?? null,
                        'doi'              => $pub['doi'] ?? null,
                        'publication_date' => $pub['year'] ?? null,
                        'authors'          => $pub['authors'] ?? null,
                        'citation_count'   => $pub['citation_count'] ?? 0,
                        'raw_data'         => json_encode($pub),
                        'type'             => null,
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error("Exception sinkronisasi Garuda: {$e->getMessage()}");
        }
    }

    public function syncFromGoogleScholar(Researcher $researcher)
    {
        if (!$researcher->googlescholar_id) {
            Log::info("Peneliti ID {$researcher->id} tidak punya Google Scholar ID.");
            return;
        }

        $apiKey = env('SERPAPI_KEY');
        $url = "https://serpapi.com/search.json?engine=google_scholar_author&author_id={$researcher->googlescholar_id}&api_key={$apiKey}";

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                Log::warning("Gagal ambil data Google Scholar: {$url} - Status: {$response->status()}");
                return;
            }

            $data = $response->json()['articles'] ?? [];

            foreach ($data as $item) {
                if (empty($item['citation_id'])) continue;

                Publication::updateOrCreate(
                    ['external_id' => $item['citation_id'], 'source' => 'google_scholar'],
                    [
                        'researcher_id'    => $researcher->id,
                        'title'            => $item['title'] ?? 'No Title',
                        'journal'          => $item['publication'] ?? null,
                        'doi'              => $item['doi'] ?? null,
                        'publication_date' => $item['year'] ?? null,
                        'authors'          => $item['authors'] ?? null,
                        'citation_count'   => $item['cited_by']['value'] ?? 0,
                        'raw_data'         => json_encode($item),
                        'type'             => null,
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error("Exception sinkronisasi Google Scholar: {$e->getMessage()}");
        }
    }
}
