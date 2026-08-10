<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/*
|--------------------------------------------------------------------------
| AI Recommendation Engine
|--------------------------------------------------------------------------
| Pure-PHP recommendation logic. Decoupled from the controller so it can
| be unit-tested and reused independently.
|
| Input  : body-proportion metrics computed in the browser by
|          TensorFlow.js + MediaPipe Pose Detection (sent to the API).
| Output : scored + ranked list of products with human-readable reasons.
|
| No images are stored. Only numeric metrics are received.
*/

class AIRecommendationService
{
    /**
     * Map numeric shoulder/hip/waist ratios to a body-type label.
     * These labels are intentionally generic and non-identifying.
     */
    public static function classifyBodyType(array $metrics): string
    {
        $shoulderToWaist = $metrics['shoulder_to_waist_ratio'] ?? 1.0;
        $waistToHip      = $metrics['waist_to_hip_ratio'] ?? 1.0;
        $shoulderToHip   = $metrics['shoulder_to_hip_ratio'] ?? 1.0;

        // Inverted triangle: broad shoulders, narrower hips
        if ($shoulderToHip > 1.15 && $waistToHip >= 0.9) {
            return 'inverted-triangle';
        }

        // Pear: hips wider than shoulders
        if ($shoulderToHip < 0.9) {
            return 'pear';
        }

        // Apple: wider waist relative to hips
        if ($waistToHip > 1.05) {
            return 'apple';
        }

        // Hourglass: balanced shoulders & hips with defined waist
        if (abs($shoulderToHip - 1.0) < 0.1 && $waistToHip < 0.85) {
            return 'hourglass';
        }

        // Rectangle: fairly uniform shoulder/waist/hip
        return 'rectangle';
    }

    /**
     * Suggest a preferred fit based on body type + user preference.
     */
    public static function suggestFit(string $bodyType, ?string $userPref = null): string
    {
        if ($userPref && in_array($userPref, ['slim', 'regular', 'relaxed', 'oversized'])) {
            return $userPref;
        }

        return match ($bodyType) {
            'inverted-triangle' => 'regular',
            'pear'              => 'relaxed',
            'apple'             => 'relaxed',
            'hourglass'         => 'slim',
            'rectangle'         => 'regular',
            default             => 'regular',
        };
    }

    /**
     * Suggest a style based on optional user preference + season.
     */
    public static function suggestStyle(?string $userPref = null): string
    {
        if ($userPref && in_array($userPref, ['casual', 'formal', 'sporty', 'ethnic', 'party'])) {
            return $userPref;
        }

        $month = (int) date('n');
        // Summer: Mar-Jun, Monsoon: Jul-Sep, Winter: Oct-Feb (India)
        return match (true) {
            in_array($month, [3, 4, 5, 6]) => 'casual',
            in_array($month, [7, 8, 9])   => 'sporty',
            default                        => 'formal',
        };
    }

    /**
     * Suggest a color category from user preference or season.
     */
    public static function suggestColor(?string $userPref = null): string
    {
        if ($userPref && in_array($userPref, ['light', 'dark', 'warm', 'cool', 'neutral'])) {
            return $userPref;
        }

        $month = (int) date('n');
        return match (true) {
            in_array($month, [3, 4, 5, 6]) => 'light',
            in_array($month, [7, 8, 9])   => 'cool',
            default                        => 'dark',
        };
    }

    /**
     * Build the recommendation list.
     *
     * @return array<int, array{product: array, score: int, reasons: array<int,string>}>
     */
    public function recommend(array $payload): array
    {
        $metrics   = $payload['metrics'] ?? [];
        $prefs     = $payload['preferences'] ?? [];
        $limit     = max(1, min(20, (int) ($payload['limit'] ?? 8)));

        $bodyType = self::classifyBodyType($metrics);
        $fit      = self::suggestFit($bodyType, $prefs['fit'] ?? null);
        $style    = self::suggestStyle($prefs['style'] ?? null);
        $color    = self::suggestColor($prefs['color'] ?? null);
        $season   = $prefs['season'] ?? $this->currentSeason();

        // Start from all products. Existing ProductController is untouched.
        $products = Product::all();

        $scored = $products->map(function (Product $product) use ($bodyType, $fit, $style, $color, $season) {
            $score   = 0;
            $reasons = [];

            // 1. Body-type match (highest weight)
            $recFor = $product->recommended_for;
            if ($recFor) {
                if ($recFor === 'any' || $recFor === $bodyType) {
                    $score += 40;
                    $reasons[] = "Flatters your {$bodyType} body shape";
                }
            }

            // 2. Fit match
            if ($product->body_fit && $product->body_fit === $fit) {
                $score += 25;
                $reasons[] = "Ideal {$fit} fit for your proportions";
            }

            // 3. Style match
            if ($product->style_type && $product->style_type === $style) {
                $score += 20;
                $reasons[] = "Matches your preferred {$style} style";
            }

            // 4. Color match
            if ($product->color_category && $product->color_category === $color) {
                $score += 15;
                $reasons[] = "Complements your {$color} color preference";
            }

            // 5. Season match
            if ($product->season && ($product->season === $season || $product->season === 'all')) {
                $score += 10;
                $reasons[] = "Great for {$season} season";
            }

            // 6. Baseline popularity nudge so unrated products still surface
            $score += min(10, (int) (($product->rating ?? 0) * 2));

            return [
                'product' => $this->productToArray($product),
                'score'   => $score,
                'reasons' => $reasons,
            ];
        })
        // Sort highest score first
        ->sortByDesc('score')
        ->take($limit)
        ->values();

        return [
            'analysis' => [
                'body_type'       => $bodyType,
                'suggested_fit'   => $fit,
                'suggested_style' => $style,
                'suggested_color' => $color,
                'season'          => $season,
                'height_ratio'    => $metrics['height_ratio'] ?? 0,
                'body_metrics'    => [
                    'shoulder_to_waist_ratio' => $metrics['shoulder_to_waist_ratio'] ?? null,
                    'waist_to_hip_ratio'      => $metrics['waist_to_hip_ratio'] ?? null,
                    'shoulder_to_hip_ratio'   => $metrics['shoulder_to_hip_ratio'] ?? null,
                    'height_ratio'            => $metrics['height_ratio'] ?? null,
                    'arm_span'                => $metrics['arm_span'] ?? null,
                    'leg_length'              => $metrics['leg_length'] ?? null,
                ],
            ],
            'recommendations' => $scored->toArray(),
        ];
    }

    /**
     * Current season label based on month (India context).
     */
    private function currentSeason(): string
    {
        $month = (int) date('n');
        return match (true) {
            in_array($month, [3, 4, 5, 6]) => 'summer',
            in_array($month, [7, 8, 9])   => 'monsoon',
            default                        => 'winter',
        };
    }

    /**
     * Serialize a product for the JSON API response.
     * Uses the existing image_url accessor; does not modify the model.
     */
    private function productToArray(Product $product): array
    {
        return [
            'id'          => $product->id,
            'name'        => $product->name,
            'category'    => $product->category,
            'price'       => (float) $product->price,
            'rating'      => (float) $product->rating,
            'stock'       => (int) $product->stock,
            'image_url'   => $product->image_url,
            'body_fit'    => $product->body_fit,
            'style_type'  => $product->style_type,
            'color_category' => $product->color_category,
            'recommended_for' => $product->recommended_for,
            'season'      => $product->season,
        ];
    }
}