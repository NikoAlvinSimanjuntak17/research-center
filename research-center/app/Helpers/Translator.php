<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Translator
{
    public static function translate($text, $target = 'en', $source = 'id')
    {
        if (empty($text)) return '';
        if ($source === $target) return $text;

        $cacheKey = 'translate_' . $source . '_' . $target . '_' . md5($text);

        // Ambil dari cache jika ada
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

$apiKey = config('services.google_translate.key');
        $url = "https://translation.googleapis.com/language/translate/v2?key={$apiKey}";

        try {
            $response = Http::timeout(10)->post($url, [
                'q' => $text,
                'target' => $target,
                'source' => $source,
                'format' => 'text',
            ]);

            if ($response->successful()) {
                $translated = $response['data']['translations'][0]['translatedText'] ?? $text;
                cache()->put($cacheKey, $translated, now()->addDays(30));
                return $translated;
            }

            Log::error('Google Translate API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Google Translate API exception', [
                'message' => $e->getMessage()
            ]);
        }

        return $text;
    }

    public static function translateRich($html, $target = 'en', $source = 'id')
    {
        if (empty($html)) return '';
        if ($source === $target) return $html;

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        $xpath = new \DOMXPath($dom);
        $textNodes = $xpath->query('//text()');

$apiKey = config('services.google_translate.key');
        $url = "https://translation.googleapis.com/language/translate/v2?key={$apiKey}";

        foreach ($textNodes as $node) {
            $originalText = trim($node->nodeValue);
            if ($originalText !== '') {
                $cacheKey = 'translate_' . $source . '_' . $target . '_' . md5($originalText);

                // Cek cache dulu
                if (cache()->has($cacheKey)) {
                    $translated = cache()->get($cacheKey);
                } else {
                    try {
                        $response = Http::timeout(10)->post($url, [
                            'q' => $originalText,
                            'target' => $target,
                            'source' => $source,
                            'format' => 'text',
                        ]);

                        if ($response->successful()) {
                            $translated = $response['data']['translations'][0]['translatedText'] ?? $originalText;
                            cache()->put($cacheKey, $translated, now()->addDays(30));
                        } else {
                            $translated = $originalText;
                            Log::error('Google Translate API error (rich)', [
                                'status' => $response->status(),
                                'body' => $response->body(),
                            ]);
                        }
                    } catch (\Exception $e) {
                        $translated = $originalText;
                        Log::error('Google Translate API exception (rich)', [
                            'message' => $e->getMessage()
                        ]);
                    }
                }

                $node->nodeValue = $translated;
            }
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        $innerHTML = '';
        foreach ($body->childNodes as $child) {
            $innerHTML .= $dom->saveHTML($child);
        }

        return $innerHTML;
    }
}
