<?php

namespace App\Http\Controllers;

use App\Services\AIRecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| AI Camera Shopping Assistant Controller
|--------------------------------------------------------------------------
| Handles the POST /api/ai-recommend endpoint.
|
| Receives ONLY numeric body-proportion metrics (computed in the browser
| by TensorFlow.js + MediaPipe Pose Detection). No images are uploaded,
| stored, or processed on the server.
|
| This controller is completely isolated from ProductController and all
| existing routes.
*/

class AICameraController extends Controller
{
    public function __construct(private AIRecommendationService $recommendationService)
    {
    }

    /**
     * POST /api/ai-recommend
     *
     * Expected JSON body:
     * {
     *   "metrics": {
     *     "shoulder_to_waist_ratio": 1.2,
     *     "waist_to_hip_ratio": 0.9,
     *     "shoulder_to_hip_ratio": 1.1
     *   },
     *   "preferences": {
     *     "fit": "slim|regular|relaxed|oversized",   // optional
     *     "style": "casual|formal|sporty|ethnic|party", // optional
     *     "color": "light|dark|warm|cool|neutral",   // optional
     *     "season": "summer|winter|monsoon|all"      // optional
     *   },
     *   "limit": 8                                   // optional, 1-20
     * }
     */
    public function recommend(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'metrics.shoulder_to_waist_ratio' => 'sometimes|numeric|min:0.1|max:5',
            'metrics.waist_to_hip_ratio'      => 'sometimes|numeric|min:0.1|max:5',
            'metrics.shoulder_to_hip_ratio'   => 'sometimes|numeric|min:0.1|max:5',
            'preferences.fit'                 => 'sometimes|string|in:slim,regular,relaxed,oversized',
            'preferences.style'               => 'sometimes|string|in:casual,formal,sporty,ethnic,party',
            'preferences.color'               => 'sometimes|string|in:light,dark,warm,cool,neutral',
            'preferences.season'              => 'sometimes|string|in:summer,winter,monsoon,all',
            'limit'                           => 'sometimes|integer|min:1|max:20',
        ]);

        $result = $this->recommendationService->recommend($validated);

        return response()->json([
            'success' => true,
            'message' => 'AI recommendations generated locally — no images stored.',
            'data'    => $result,
        ]);
    }
}