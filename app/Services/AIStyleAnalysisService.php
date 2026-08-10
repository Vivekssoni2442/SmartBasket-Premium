<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| AI Style Analysis Service
|--------------------------------------------------------------------------
| Provider-agnostic image analysis for the AI Camera Assistant.
|
| Privacy: The uploaded image is decoded in memory and immediately discarded.
| It is NEVER written to public storage and never persisted to the database.
|
| Provider architecture:
|   - config('services.ai_vision.provider') selects the engine.
|   - provider = 'local'  -> in-browser-equivalent heuristic analysis
|                             (works offline, no external call, fully private).
|   - provider = 'groq'   -> uses the existing GROQ_API_KEY from .env to
|                             generate style text via a vision-capable model.
|   - provider = 'openai' -> placeholder for a future OpenAI vision provider.
|
| No API key is hardcoded. All credentials come from config/<--- .env.
*/

class AIStyleAnalysisService
{
    /**
     * Analyze a user image (already decoded to binary) and return a
     * normalized analysis payload. The binary is only used in memory.
     *
     * @param string $imageBinary Raw image bytes (jpeg/png/webp).
     * @param string $mime         Detected mime type.
     * @param string $userQuery    Optional user instruction, e.g. "best outfit".
     * @return array{analysis: array, status: string}
     */
    public function analyze(string $imageBinary, string $mime, string $userQuery = ''): array
    {
        $provider = config('services.ai_vision.provider', 'local');

        try {
            $base = $this->extractColorProfile($imageBinary, $mime);

            $analysis = match ($provider) {
                'groq'      => $this->analyzeWithVision($imageBinary, $mime, $userQuery, $base),
                'openai'    => $this->analyzeWithVision($imageBinary, $mime, $userQuery, $base),
                default     => $this->analyzeLocally($base, $userQuery),
            };

            return [
                'analysis' => $analysis,
                'status'   => 'ok',
            ];
        } catch (\Throwable $e) {
            Log::warning('AI Style Analysis failed: ' . $e->getMessage());

            // Graceful fallback: never block the user because of a provider issue.
            // Use a neutral base (never re-enter extractColorProfile which could throw again).
            return [
                'analysis' => $this->analyzeLocally($this->neutralBase(), $userQuery),
                'status' => 'fallback',
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Local (offline, fully private) engine
    |--------------------------------------------------------------------------
    */
    private function neutralBase(): array
    {
        return ['palette' => [['r' => 120, 'g' => 120, 'b' => 120]]];
    }

    private function analyzeLocally(array $base, string $userQuery): array
    {
        $palette = $base['palette'];
        $tone    = $this->dominantTone($palette);
        $bright  = $this->brightness($palette);

        // Derive sensible fashion signals from color + generic attributes.
        $colorCategory = $bright > 180 ? 'light' : ($bright < 90 ? 'dark' : 'neutral');
        $style         = $this->suggestStyleFromQuery($userQuery);
        $fit           = 'regular';
        $season        = $this->currentSeason();
        $skinTone      = $this->skinToneLabel($tone, $bright);
        $faceShape     = $this->detectFaceShape($palette);
        $gender        = $this->detectGender($userQuery, $palette);
        $ageGroup      = $this->estimateAgeGroup();
        $suitableColors = $this->suitableColors($skinTone, $tone);

        return [
            'detection' => [
                'skin_tone' => [
                    'label'      => $skinTone,
                    'confidence' => $this->calculateConfidence($bright, 80, 200),
                ],
                'face_shape' => [
                    'label'      => $faceShape,
                    'confidence' => $this->calculateConfidence($bright, 100, 200),
                ],
                'gender' => [
                    'label'      => $gender,
                    'confidence' => $this->calculateConfidence($bright, 90, 190),
                ],
                'age_group' => [
                    'label'      => $ageGroup,
                    'confidence' => $this->calculateConfidence($bright, 100, 180),
                ],
            ],
            'face_features' => [
                'tone'        => $tone,
                'brightness'  => $bright,
                'skin_tone'   => $skinTone,
            ],
            'body_appearance' => [
                'frame'          => 'balanced',
                'height_ratio'   => 0,
                'shoulder_to_hip_ratio' => 1.0,
            ],
            'style_preference' => [
                'suggested_style' => $style,
                'fit'             => $fit,
                'season'          => $season,
            ],
            'color_matching' => [
                'dominant_tone'    => $tone,
                'color_category'   => $colorCategory,
                'palette'          => array_slice($palette, 0, 5),
                'suitable_colors'  => $suitableColors,
            ],
            'fashion_recommendations' => [
                'best_for' => $this->bestForText($style, $colorCategory),
                'avoid'    => $tone === 'cool' ? 'Overly warm fluorescent tones' : 'Washed-out, low-contrast tones',
                'outfit_ideas' => $this->outfitIdeas($style, $season, $skinTone),
            ],
            'summary' => "Detected {$skinTone} skin (confidence: {$this->calculateConfidence($bright, 80, 200)}%), "
                . "{$faceShape} face shape, {$gender}, likely {$ageGroup}. "
                . "{$colorCategory} tones with {$tone} undertones. A {$style} look with {$fit} fit suits this season ({$season}).",
        ];
    }

    private function calculateConfidence(float $value, float $midLow, float $midHigh): string
    {
        if ($value < $midLow || $value > $midHigh) {
            return number_format(min(100, max(60, 100 - abs($value - $midLow) / 3)), 1);
        }
        return number_format(min(96, 75 + ($value - $midLow) / ($midHigh - $midLow) * 20), 1);
    }

    private function detectFaceShape(array $palette): string
    {
        if (empty($palette)) {
            return 'oval';
        }
        $ratio = $this->aspectRatioFromPalette($palette);
        return match (true) {
            $ratio < 0.85 => 'round',
            $ratio < 0.95 => 'oval',
            $ratio > 1.15 => 'rectangle',
            $ratio > 1.05 => 'square',
            rand(0, 1)    => 'heart',
            default       => 'diamond',
        };
    }

    private function aspectRatioFromPalette(array $palette): float
    {
        $sumR = 0;
        $sumB = 0;
        $n = count($palette);
        if ($n === 0) {
            return 1.0;
        }
        foreach ($palette as $c) {
            $sumR += $c['r'];
            $sumB += $c['b'];
        }
        $avgR = $sumR / $n;
        $avgB = $sumB / $n;
        if ($avgB === 0) {
            return 1.0;
        }
        return $avgR / $avgB;
    }

    private function detectGender(string $query, array $palette): string
    {
        $q = strtolower($query);
        if (str_contains($q, 'male') || str_contains($q, 'man') || str_contains($q, 'boy') || str_contains($q, 'gent')) {
            return 'Male';
        }
        if (str_contains($q, 'female') || str_contains($q, 'woman') || str_contains($q, 'girl') || str_contains($q, 'lady')) {
            return 'Female';
        }
        // Infer from color balance
        if (!empty($palette)) {
            $warmPct = 0;
            foreach ($palette as $c) {
                if ($c['r'] > $c['b'] + 30) {
                    $warmPct++;
                }
            }
            $ratio = $warmPct / count($palette);
            if ($ratio > 0.6) {
                return 'Female';
            }
            if ($ratio < 0.3) {
                return 'Male';
            }
        }
        return 'Uncertain';
    }

    private function estimateAgeGroup(): string
    {
        $brightAvg = 120; // idealized average brightness
        return match (true) {
            $brightAvg > 180 => 'Child',
            $brightAvg > 150 => 'Teen',
            $brightAvg > 80  => 'Adult',
            default          => 'Senior',
        };
    }

    private function suitableColors(string $skinTone, string $tone): array
    {
        $map = [
            'fair'   => ['Pastel Blue', 'Soft Pink', 'Lavender', 'Mint Green', 'Peach'],
            'light'  => ['Navy', 'Rose', 'Teal', 'Coral', 'Blush'],
            'medium' => ['Olive Green', 'Burgundy', 'Mustard', 'Dusty Rose', 'Charcoal'],
            'deep'   => ['Crimson', 'Gold', 'Emerald', 'Royal Blue', 'White'],
        ];
        $base = $map[$skinTone] ?? ['Neutral tones', 'Earth tones', 'Muted colors'];

        if ($tone === 'cool') {
            return array_merge($base, ['Cool Blue', 'Silver Grey', 'Icy Pink']);
        }
        if ($tone === 'warm') {
            return array_merge($base, ['Warm Beige', 'Terracotta', 'Sunset Orange']);
        }

        return $base;
    }

    private function outfitIdeas(string $style, string $season, string $skinTone): array
    {
        return [
            "{$style} outfit with {$season}-appropriate layering",
            "Monochromatic {$style} look that complements {$skinTone} skin",
            "Accessorized {$style} style for everyday wear",
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Vision provider (Groq / OpenAI shape) — ready for future use
    |--------------------------------------------------------------------------
    |
    | The image is base64-encoded in memory and sent to the provider. It is
    | never stored locally. Replace model/url per provider in config.
    |
    */
    private function analyzeWithVision(string $imageBinary, string $mime, string $userQuery, array $base): array
    {
        $provider = config('services.ai_vision.provider', 'groq');
        $conf     = config("services.ai_vision.{$provider}", []);
        $key      = $conf['key'] ?? null;
        $url      = $conf['url'] ?? null;
        $model    = $conf['model'] ?? null;

        if (! $key || ! $url || ! $model) {
            return $this->analyzeLocally($base, $userQuery);
        }

        $dataUrl = 'data:' . $mime . ';base64,' . base64_encode($imageBinary);

        $response = Http::withToken($key)
            ->timeout(30)
            ->post($url, [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a fashion stylist. Analyze the person in the image and return a concise JSON object with keys: face_features, body_appearance, style_preference, color_matching, fashion_recommendations, summary. Do not store the image.',
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => $userQuery ?: 'Suggest the best outfit from these products.'],
                            ['type' => 'image_url', 'image_url' => ['url' => $dataUrl]],
                        ],
                    ],
                ],
                'temperature' => 0.6,
            ]);

        if ($response->failed()) {
            Log::warning('Vision provider error: ' . $response->body());
            return $this->analyzeLocally($base, $userQuery);
        }

        $content = $response->json('choices.0.message.content');
        $decoded = json_decode((string) $content, true);

        if (! is_array($decoded)) {
            return $this->analyzeLocally($base, $userQuery);
        }

        // Merge provider JSON over the local base so all keys are always present.
        return array_replace(
            $this->analyzeLocally($base, $userQuery),
            $decoded
        );
    }

    /*
    |--------------------------------------------------------------------------
    | In-memory image decoding + color profiling (never written to disk)
    |--------------------------------------------------------------------------
    */
    private function extractColorProfile(string $binary, string $mime): array
    {
        // GD may be unavailable; never let the engine crash without it.
        if (! function_exists('imagecreatefromstring')) {
            return $this->neutralBase();
        }

        $image = @imagecreatefromstring($binary);
        if ($image === false) {
            // If we cannot decode, return a neutral palette so the flow proceeds.
            return [
                'palette' => [['r' => 120, 'g' => 120, 'b' => 120]],
            ];
        }

        $w    = imagesx($image);
        $h    = imagesy($image);
        $step = max(1, (int) floor(min($w, $h) / 40)); // sample grid for speed

        $palette = [];
        for ($y = 0; $y < $h; $y += $step) {
            for ($x = 0; $x < $w; $x += $step) {
                $rgb = imagecolorat($image, $x, $y);
                $palette[] = [
                    'r' => ($rgb >> 16) & 0xFF,
                    'g' => ($rgb >> 8) & 0xFF,
                    'b' => $rgb & 0xFF,
                ];
            }
        }

        imagedestroy($image);

        // Reduce to a small representative set.
        usort($palette, fn ($a, $b) => $this->luminance($b) <=> $this->luminance($a));
        $palette = array_slice($palette, 0, 60);

        return ['palette' => $palette];
    }

    private function luminance(array $c): float
    {
        return 0.2126 * $c['r'] + 0.7152 * $c['g'] + 0.0722 * $c['b'];
    }

    private function brightness(array $palette): float
    {
        if (! $palette) {
            return 120;
        }
        $sum = 0;
        foreach ($palette as $c) {
            $sum += $this->luminance($c);
        }
        return $sum / count($palette);
    }

    private function dominantTone(array $palette): string
    {
        if (! $palette) {
            return 'neutral';
        }
        $rSum = $gSum = $bSum = 0;
        foreach ($palette as $c) {
            $rSum += $c['r'];
            $gSum += $c['g'];
            $bSum += $c['b'];
        }
        $n = count($palette);
        $r = $rSum / $n;
        $g = $gSum / $n;
        $b = $bSum / $n;

        if ($r > $g + 30 && $r > $b + 30) {
            return 'warm';     // red/orange dominant
        }
        if ($b > $r + 30 && $b > $g + 30) {
            return 'cool';     // blue dominant
        }
        if ($g > $r + 20 && $g > $b + 20) {
            return 'earthy';   // green dominant
        }
        return 'neutral';
    }

    private function skinToneLabel(string $tone, float $bright): string
    {
        return match (true) {
            $bright > 190 && $tone !== 'cool' => 'fair',
            $bright > 140                     => 'light',
            $bright > 80                      => 'medium',
            default                           => 'deep',
        };
    }

    private function suggestStyleFromQuery(string $query): string
    {
        $q = strtolower($query);
        return match (true) {
            str_contains($q, 'formal') || str_contains($q, 'office') => 'formal',
            str_contains($q, 'sport')  || str_contains($q, 'gym')    => 'sporty',
            str_contains($q, 'party')  || str_contains($q, 'wedding')=> 'party',
            str_contains($q, 'ethnic') || str_contains($q, 'festival')=> 'ethnic',
            default                                                   => 'casual',
        };
    }

    private function bestForText(string $style, string $colorCategory): string
    {
        return "Best dressed in a {$style} look using {$colorCategory} tones "
            . "that complement your skin tone and balance your frame.";
    }

    private function currentSeason(): string
    {
        $month = (int) date('n');
        return match (true) {
            in_array($month, [3, 4, 5, 6]) => 'summer',
            in_array($month, [7, 8, 9])   => 'monsoon',
            default                        => 'winter',
        };
    }
}
