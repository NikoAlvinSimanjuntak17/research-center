<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class Translator
{
public static function translate($text, $target = 'en', $source = 'id')
{
    if (empty($text)) return '';

    // Kalau source dan target sama, tidak perlu translate
    if ($source === $target) return $text;

    $cacheKey = 'translate_' . $source . '_' . $target . '_' . md5($text);

    return cache()->remember($cacheKey, now()->addDays(30), function () use ($text, $target, $source) {
        $apiKey = config('services.google_translate.key');

        $url = "https://translation.googleapis.com/language/translate/v2?key={$apiKey}";

        $response = Http::post($url, [
            'q' => $text,
            'target' => $target,
            'source' => $source,
            'format' => 'text',
        ]);

        if (!$response->successful()) {
            Log::error('Google Translate API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return $text;
        }

        return $response['data']['translations'][0]['translatedText'] ?? $text;
    });
}

public static function translateRich($html, $target = 'en', $source = 'id')
{
    if (empty($html)) return '';

    $dom = new \DOMDocument();
    libxml_use_internal_errors(true); // suppress warning for malformed HTML
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $xpath = new \DOMXPath($dom);
    $textNodes = $xpath->query('//text()');

    $apiKey = config('services.google_translate.key');
    $url = "https://translation.googleapis.com/language/translate/v2?key={$apiKey}";

    foreach ($textNodes as $node) {
        $originalText = trim($node->nodeValue);
        if ($originalText !== '') {
            // Translate text only
            $response = Http::post($url, [
                'q' => $originalText,
                'target' => $target,
                'source' => $source,
                'format' => 'text',
            ]);

            if ($response->successful()) {
                $translatedText = $response['data']['translations'][0]['translatedText'] ?? $originalText;
                $node->nodeValue = $translatedText;
            }
        }
    }

    $body = $dom->getElementsByTagName('body')->item(0);
    $innerHTML = '';
    foreach ($body->childNodes as $child) {
        $innerHTML .= $dom->saveHTML($child);
    }

    return $innerHTML; // langsung bisa pakai {!! !!} di Blade
}



}
