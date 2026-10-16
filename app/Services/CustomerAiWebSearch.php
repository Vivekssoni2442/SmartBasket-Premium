<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerAiWebSearch
{
    /** Search a configured provider without ever fetching result URLs from this server. */
    public function search(string $query, string $topic = 'general'): array
    {
        $query = $this->normalizeQuery($query);

        if ($query === null) {
            return $this->failure('invalid_query', 'Please provide a short, non-empty public search query.');
        }

        $topic = in_array($topic, ['general', 'news'], true) ? $topic : 'general';
        $config = config('services.customer_ai_web', []);
        if (($config['provider'] ?? 'tavily') === 'google') {
            $result = $this->cachedSearch(
                'google',
                $query,
                $topic,
                fn () => $this->searchGoogleGrounded($query, $topic, $config),
                $config
            );

            $this->logFailure('google', $result);

            if (($result['ok'] ?? false)
                || ($config['fallback_provider'] ?? null) !== 'tavily') {
                return $result;
            }

            $fallback = $this->cachedSearch(
                'tavily',
                $query,
                $topic,
                fn () => $this->searchTavily($query, $topic, $config),
                $config
            );

            $this->logFailure('tavily', $fallback);

            if ($fallback['ok'] ?? false) {
                $fallback['fallback_from'] = 'google';
            }

            return $fallback;
        }

        if (($config['provider'] ?? 'tavily') === 'tavily') {
            $result = $this->cachedSearch(
                'tavily',
                $query,
                $topic,
                fn () => $this->searchTavily($query, $topic, $config),
                $config
            );

            $this->logFailure('tavily', $result);

            if (($result['ok'] ?? false)
                || ($config['fallback_provider'] ?? null) !== 'google') {
                return $result;
            }

            $fallback = $this->cachedSearch(
                'google',
                $query,
                $topic,
                fn () => $this->searchGoogleGrounded($query, $topic, $config),
                $config
            );

            $this->logFailure('google', $fallback);

            if ($fallback['ok'] ?? false) {
                $fallback['fallback_from'] = 'tavily';
            }

            return $fallback;
        }

        return $this->failure('web_search_unavailable', 'The configured live web search provider is not supported.');
    }

    private function cachedSearch(string $provider, string $query, string $topic, callable $search, array $config): array
    {
        $cacheKey = 'customer_ai_web.'.$provider.'.'.hash('sha256', mb_strtolower($topic.'|'.$query));
        $cacheTtl = max(0, min(3600, (int) ($config['cache_ttl'] ?? 300)));

        if ($cacheTtl > 0) {
            try {
                $cached = Cache::get($cacheKey);
                if (is_array($cached) && ($cached['ok'] ?? false) === true) {
                    return $cached;
                }
            } catch (\Throwable) {
                // Cache is an optimization; provider requests remain available.
            }
        }

        $result = $search();
        if ($cacheTtl > 0 && ($result['ok'] ?? false)) {
            try {
                Cache::put($cacheKey, $result, now()->addSeconds($cacheTtl));
            } catch (\Throwable) {
                // A cache write failure must not discard real provider results.
            }
        }

        return $result;
    }

    private function searchTavily(string $query, string $topic, array $config): array
    {
        $apiKey = trim((string) ($config['key'] ?? ''));
        $keyless = (bool) ($config['keyless'] ?? false);

        if ($apiKey === '' && ! $keyless) {
            return $this->failure('web_search_unavailable', 'Live web search is not configured.');
        }

        if (! $this->isOfficialEndpoint((string) ($config['url'] ?? ''))) {
            return $this->failure('web_search_unavailable', 'Live web search is not configured safely.');
        }

        $request = Http::acceptJson()
            ->asJson()
            ->connectTimeout(5)
            ->timeout(max(3, min(30, (int) ($config['timeout'] ?? 15))))
            ->withOptions(['allow_redirects' => false]);

        $request = $apiKey !== ''
            ? $request->withToken($apiKey)
            : $request->withHeaders(['X-Tavily-Access-Mode' => 'keyless']);

        try {
            $response = $request->post('https://api.tavily.com/search', [
                'query' => $query,
                'topic' => $topic,
                'search_depth' => 'basic',
                'max_results' => max(1, min(5, (int) ($config['results'] ?? 5))),
                'chunks_per_source' => 2,
                'include_answer' => false,
                'include_raw_content' => false,
                'include_published_date' => true,
            ]);
        } catch (ConnectionException $exception) {
            $timeout = str_contains(mb_strtolower($exception->getMessage()), 'timed out');

            return $this->failure(
                $timeout ? 'web_search_timeout' : 'web_search_unavailable',
                $timeout ? 'Live web search timed out. Please try again shortly.' : 'The live search provider could not be reached.'
            );
        } catch (\Throwable) {
            return $this->failure('web_search_unavailable', 'The live search provider could not be reached.');
        }

        if ($response->status() === 401 || $response->status() === 403) {
            return $this->failure('web_search_auth_failed', 'Live web search could not authenticate. Check the server-side Tavily configuration.');
        }

        if ($response->status() === 429) {
            $retryAfter = filter_var($response->header('Retry-After'), FILTER_VALIDATE_INT);

            return array_merge(
                $this->failure('web_search_rate_limited', 'Live web search is temporarily rate limited. Please try again later.'),
                ['retry_after' => $retryAfter === false ? null : max(0, min(3600, $retryAfter))]
            );
        }

        if ($response->serverError()) {
            return $this->failure('web_search_unavailable', 'The live search provider is temporarily unavailable.');
        }

        if ($response->failed()) {
            return $this->failure('web_search_rejected', 'The live search provider rejected this query.');
        }

        $payload = $response->json();
        if (! is_array($payload) || ! isset($payload['results']) || ! is_array($payload['results'])) {
            return $this->failure('web_search_malformed_response', 'The live search provider returned an unreadable response.');
        }

        $sources = collect($payload['results'])
            ->take(5)
            ->filter(fn ($result) => is_array($result))
            ->map(fn (array $result) => $this->formatSource($result))
            ->filter()
            ->values()
            ->all();

        return [
            'ok' => true,
            'provider' => 'tavily',
            'query' => $query,
            'searched_at' => now()->toIso8601String(),
            'count' => count($sources),
            'sources' => $sources,
            'message' => $sources === [] ? 'No relevant web sources were found.' : null,
        ];
    }

    /** Use Google's official Gemini API Google Search grounding tool. */
    private function searchGoogleGrounded(string $query, string $topic, array $config): array
    {
        $apiKey = trim((string) ($config['google_key'] ?? ''));
        if ($apiKey === '') {
            return $this->failure('web_search_unavailable', 'Google Search grounding is not configured. Set GOOGLE_GEMINI_API_KEY on the server.');
        }

        if (! $this->isGoogleInteractionsEndpoint((string) ($config['google_url'] ?? ''))) {
            return $this->failure('web_search_unavailable', 'Google Search grounding is not configured safely.');
        }

        $prompt = $topic === 'news'
            ? "Find current news information for this public query. Prefer recent reporting and state dates when relevant: {$query}"
            : "Research this public query using current Google Search results. Give a concise factual evidence summary: {$query}";

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->connectTimeout(5)
                ->timeout(max(3, min(30, (int) ($config['timeout'] ?? 15))))
                ->withOptions(['allow_redirects' => false])
                ->post((string) $config['google_url'], [
                    'model' => (string) ($config['google_model'] ?? 'gemini-2.5-flash'),
                    'input' => $prompt,
                    'tools' => [['type' => 'google_search']],
                ]);
        } catch (ConnectionException $exception) {
            $timeout = str_contains(mb_strtolower($exception->getMessage()), 'timed out');

            return $this->failure(
                $timeout ? 'web_search_timeout' : 'web_search_unavailable',
                $timeout ? 'Google Search grounding timed out. Please try again shortly.' : 'Google Search grounding could not be reached.'
            );
        } catch (\Throwable) {
            return $this->failure('web_search_unavailable', 'Google Search grounding could not be reached.');
        }

        if ($response->status() === 401 || $response->status() === 403) {
            return $this->failure('web_search_auth_failed', 'Google Search grounding could not authenticate. Check the server-side Google Gemini API key and project access.');
        }

        if ($response->status() === 429) {
            return $this->failure('web_search_rate_limited', 'Google Search grounding is temporarily rate limited. Please try again later.');
        }

        if ($response->failed()) {
            return $this->failure('web_search_unavailable', 'Google Search grounding is temporarily unavailable.');
        }

        $payload = $response->json();
        $answerParts = [];
        $sources = [];
        $searchQueries = [];
        $searchWasPerformed = false;

        foreach (($payload['steps'] ?? []) as $step) {
            if (! is_array($step)) continue;

            if (($step['type'] ?? '') === 'google_search_call') {
                $searchWasPerformed = true;
                foreach (($step['arguments']['queries'] ?? []) as $searchQuery) {
                    if (is_string($searchQuery)) $searchQueries[] = $this->plainText($searchQuery, 300);
                }
            }

            if (($step['type'] ?? '') !== 'model_output') continue;
            foreach (($step['content'] ?? []) as $block) {
                if (! is_array($block) || ($block['type'] ?? '') !== 'text') continue;
                $answer = $this->plainText((string) ($block['text'] ?? ''), 5000);
                if ($answer !== '') $answerParts[] = $answer;

                foreach (($block['annotations'] ?? []) as $annotation) {
                    if (! is_array($annotation) || ($annotation['type'] ?? '') !== 'url_citation') continue;
                    $source = $this->formatGoogleSource($annotation, $answer);
                    if ($source) $sources[$source['url']] = $source;
                }
            }
        }

        $answer = trim(implode("\n\n", array_unique($answerParts)));
        if (! $searchWasPerformed) {
            return $this->failure('web_search_not_performed', 'Google did not run a search for this query, so no current web results were returned.');
        }

        if ($answer === '') {
            return $this->failure('web_search_malformed_response', 'Google Search grounding returned no readable answer.');
        }

        return [
            'ok' => true,
            'provider' => 'google',
            'query' => $query,
            'searched_at' => now()->toIso8601String(),
            'search_queries' => array_values(array_unique(array_filter($searchQueries))),
            'grounded_answer' => $answer,
            'count' => count($sources),
            'sources' => array_values($sources),
            'message' => $sources === [] ? 'Google Search did not return cited sources for this query.' : null,
        ];
    }

    private function isGoogleInteractionsEndpoint(string $endpoint): bool
    {
        $parts = parse_url($endpoint);

        return is_array($parts)
            && strtolower((string) ($parts['scheme'] ?? '')) === 'https'
            && strtolower((string) ($parts['host'] ?? '')) === 'generativelanguage.googleapis.com'
            && ($parts['path'] ?? '') === '/v1beta/interactions'
            && ! isset($parts['user'])
            && ! isset($parts['pass'])
            && ! isset($parts['query'])
            && ! isset($parts['fragment'])
            && (! isset($parts['port']) || (int) $parts['port'] === 443);
    }

    private function formatGoogleSource(array $citation, string $answer): ?array
    {
        $url = filter_var($citation['url'] ?? null, FILTER_VALIDATE_URL);
        $parts = is_string($url) ? parse_url($url) : false;
        if (! is_array($parts)
            || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
            || empty($parts['host'])
            || isset($parts['user'])
            || isset($parts['pass'])) {
            return null;
        }

        $title = $this->plainText((string) ($citation['title'] ?? $parts['host']), 200);
        if ($title === '') $title = strtolower((string) $parts['host']);

        return [
            'title' => $title,
            'url' => $url,
            'domain' => strtolower((string) $parts['host']),
            'snippet' => $answer,
            'published_date' => null,
            'publication_date_is_estimate' => false,
        ];
    }

    private function normalizeQuery(string $query): ?string
    {
        $query = strip_tags($query);
        $query = preg_replace('/[\x00-\x1F\x7F]/u', ' ', $query) ?? '';
        $query = trim(preg_replace('/\s+/u', ' ', $query) ?? '');

        if ($query === '' || mb_strlen($query) > 300) {
            return null;
        }

        // Avoid forwarding obvious personal identifiers to a public search engine.
        $hasEmail = preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/iu', $query) === 1;
        $hasPhone = preg_match('/(?<!\w)\+?\d[\d ().-]{7,}\d(?!\w)/u', $query) === 1;
        $hasAccountReference = preg_match('/\b(?:order|invoice|tracking|account|customer)\s*(?:number|no\.?|id|#)?\s*[:#-]?\s*[A-Z0-9-]*\d[A-Z0-9-]{3,}\b/iu', $query) === 1;
        if ($hasEmail || $hasPhone || $hasAccountReference) {
            return null;
        }

        return $query;
    }

    private function isOfficialEndpoint(string $endpoint): bool
    {
        $parts = parse_url($endpoint);

        return is_array($parts)
            && strtolower((string) ($parts['scheme'] ?? '')) === 'https'
            && strtolower((string) ($parts['host'] ?? '')) === 'api.tavily.com'
            && ($parts['path'] ?? '') === '/search'
            && ! isset($parts['user'])
            && ! isset($parts['pass'])
            && ! isset($parts['query'])
            && ! isset($parts['fragment'])
            && (! isset($parts['port']) || (int) $parts['port'] === 443);
    }

    private function formatSource(array $result): ?array
    {
        $url = filter_var($result['url'] ?? null, FILTER_VALIDATE_URL);
        $parts = is_string($url) ? parse_url($url) : false;

        if (! is_array($parts)
            || ! in_array(strtolower((string) ($parts['scheme'] ?? '')), ['https', 'http'], true)
            || empty($parts['host'])
            || isset($parts['user'])
            || isset($parts['pass'])) {
            return null;
        }

        $title = $this->plainText((string) ($result['title'] ?? ''), 200);
        $snippet = $this->plainText((string) ($result['content'] ?? ''), 900);
        if ($title === '' || $snippet === '') {
            return null;
        }

        $publishedDate = $result['published_date'] ?? null;

        return [
            'title' => $title,
            'url' => $url,
            'domain' => strtolower((string) $parts['host']),
            'snippet' => $snippet,
            'published_date' => is_string($publishedDate) && trim($publishedDate) !== ''
                ? $this->plainText($publishedDate, 100)
                : null,
            'publication_date_is_estimate' => is_string($publishedDate) && trim($publishedDate) !== '',
        ];
    }

    private function plainText(string $text, int $limit): string
    {
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[\x00-\x1F\x7F]/u', ' ', $text) ?? '';
        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? '');

        return mb_substr($text, 0, $limit);
    }

    private function failure(string $error, string $message): array
    {
        return ['ok' => false, 'error' => $error, 'message' => $message, 'sources' => []];
    }

    private function logFailure(string $provider, array $result): void
    {
        if ($result['ok'] ?? false) {
            return;
        }

        Log::notice('Customer AI live search provider failed.', [
            'provider' => $provider,
            'error' => (string) ($result['error'] ?? 'web_search_unavailable'),
        ]);
    }
}
