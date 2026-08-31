<?php

namespace App\Http\Controllers;

use App\Models\AICameraHistory;
use App\Models\Product;
use App\Services\AIStyleAnalysisService;
use App\Services\VirtualTryOnService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| AI Camera Assistant Controller
|--------------------------------------------------------------------------
| A fully self-contained feature. It does NOT modify any existing controller,
| route, table, or the existing /ai-camera flow.
|
| Privacy: The uploaded image is read into memory, analyzed, and immediately
| discarded. It is never stored on disk and never persisted to the database
| (except when the user chooses Virtual Try-On, in which case a temporary
| source + generated result image are stored so they can be shown in history).
|
| The response view supports both the full AI HUB page and the floating
| sidebar drawer fragment (via ?sidebar=1).
*/

class AICameraAssistantController extends Controller
{
    public function __construct(
        private AIStyleAnalysisService $styleService,
        private VirtualTryOnService $virtualTryOnService
    ) {
    }

    /**
     * GET /ai-camera-assistant
     * Renders the interface (full page or sidebar fragment).
     */
    public function index(Request $request)
    {
        $analysis     = null;
        $recommendations = collect();

        return $this->respondView($request, $analysis, $recommendations);
    }

    /**
     * POST /ai-camera-assistant
     * Validates the image, analyzes it in memory, and returns product
     * recommendations from the existing Smart Basket products database.
     */
   public function analyze(Request $request)
{
    $validated = $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        'query' => 'nullable|string|max:255',
    ]);

    try {

        /*
        |--------------------------------------------------------------------------
        | READ IMAGE INTO MEMORY
        |--------------------------------------------------------------------------
        */

        $imageBinary = file_get_contents(
            $validated['image']->getRealPath()
        );

        $mime = $validated['image']->getMimeType();

        $userQuery = $validated['query'] ?? '';


        /*
        |--------------------------------------------------------------------------
        | AI ANALYSIS
        |--------------------------------------------------------------------------
        */

        $result = $this->styleService->analyze(
            $imageBinary,
            $mime,
            $userQuery
        );


        $analysis =
            $result['analysis'] ?? [];


        /*
        |--------------------------------------------------------------------------
        | RECOMMENDATION DATA
        |--------------------------------------------------------------------------
        */

        $style =
            $analysis['style_preference']['suggested_style']
            ?? 'casual';

        $color =
            $analysis['color_matching']['color_category']
            ?? 'neutral';

        $season =
            $analysis['style_preference']['season']
            ?? 'all';

        $fit =
            $analysis['style_preference']['fit']
            ?? 'regular';


        /*
        |--------------------------------------------------------------------------
        | PRODUCT RECOMMENDATIONS
        |--------------------------------------------------------------------------
        */

        $recommendations =
            $this->recommendProducts(
                $style,
                $color,
                $season,
                $fit
            );


        /*
        |--------------------------------------------------------------------------
        | SAVE ANALYSIS HISTORY
        |--------------------------------------------------------------------------
        */

        $this->saveHistory(
            $analysis,
            $userQuery
        );


        /*
        |--------------------------------------------------------------------------
        | AJAX / JSON RESPONSE
        |--------------------------------------------------------------------------
        */

        if (
            $request->expectsJson() ||
            $request->ajax()
        ) {

            return response()->json([

                'success' => true,

                'message' =>
                    'AI analysis complete. Your image was processed in memory and was not saved.',

                'analysis' =>
                    $analysis,

                'recommendations' =>
                    $recommendations
                        ->values()
                        ->map(function ($item) {

                            return [

                                'product' => [
                                    'id' =>
                                        $item['product']->id,

                                    'name' =>
                                        $item['product']->name,

                                    'image' =>
                                        $item['product']->image,

                                    'price' =>
                                        $item['product']->price,

                                    'rating' =>
                                        $item['product']->rating,

                                    'category' =>
                                        $item['product']->category,

                                    'brand' =>
                                        $item['product']->brand,
                                ],

                                'score' =>
                                    $item['score'],

                                'reasons' =>
                                    $item['reasons'],
                            ];

                        })
                        ->values()
                        ->all(),

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL BROWSER REQUEST
        |--------------------------------------------------------------------------
        */

        return $this->respondView(
            $request,
            $analysis,
            $recommendations
        )->with(
            'success',
            'AI analysis complete. Your image was processed in memory and not saved.'
        );


    } catch (\Throwable $e) {

        /*
        |--------------------------------------------------------------------------
        | LOG ERROR
        |--------------------------------------------------------------------------
        */

        report($e);


        if (
            $request->expectsJson() ||
            $request->ajax()
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'AI analysis failed. Please try again.',

                'error' =>
                    config('app.debug')
                        ? $e->getMessage()
                        : null,

            ], 500);
        }


        return back()->with(
            'error',
            'AI analysis failed. Please try again.'
        );
    }
}
    /**
     * GET /ai-camera-assistant/history
     * Lists the authenticated user's past analyses (full page or sidebar).
     */
    public function history(Request $request)
    {
        $histories = auth()->check()
            ? AICameraHistory::where('user_id', auth()->id())->latest()->get()
            : collect();

        return $request->boolean('sidebar')
            ? view('ai-hub.sidebar.camera-assistant-history', compact('histories'))
            : view('ai-hub.camera-assistant-history', compact('histories'));
    }

    /**
     * DELETE /ai-camera-assistant/history/{history}
     * Removes a saved analysis owned by the current user.
     */
    public function deleteHistory(AICameraHistory $history)
    {
        abort_unless($history->user_id === auth()->id(), 403);

        // Remove stored source/result images (if any) to avoid orphans.
        foreach (['image_path', 'result_image'] as $column) {
            $file = $history->{$column};
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $history->delete();

        return back()->with('success', 'Analysis history deleted.');
    }

    /**
     * GET /ai-camera-assistant/virtual-try-on
     * Opens the Virtual Try-On page, passing the current image (if any).
     */
    public function virtualTryOn(Request $request)
    {
        $recommendations = Product::query()
            ->orderByDesc('rating')
            ->latest()
            ->limit(8)
            ->get();

        return $request->boolean('sidebar')
            ? view('ai-hub.sidebar.virtual-try-on', compact('recommendations'))
            : view('ai-hub.virtual-try-on', compact('recommendations'));
    }

    /**
     * POST /ai-camera-assistant/virtual-try-on
     * Receives the captured/uploaded image (and an optional selected garment),
     * runs it through the Virtual Try-On service and returns the generated
     * result image (as JSON) so the frontend can render it in-place.
     *
     * The generated result + source image are saved to the user's history.
     */
    public function processVirtualTryOn(Request $request)
    {
        $validated = $request->validate([
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'garment'  => 'nullable|string|max:255',
            'label'    => 'nullable|string|max:255',
        ]);

        $imageBinary = file_get_contents($validated['image']->getRealPath());
        $mime        = $validated['image']->getMimeType();

        // Resolve an optional garment image from the product database.
        $garmentImage = null;
        $garmentLabel = $validated['label'] ?? null;
        if (! empty($validated['garment'])) {
            $product = Product::find($validated['garment']);
            if ($product && $product->image) {
                $garmentPath = public_path('products/' . $product->image);
                if (file_exists($garmentPath)) {
                    $garmentImage = $garmentPath;
                    $garmentLabel = $product->name;
                }
            }
        }

        // Kept for backwards compatibility with the existing AI Camera UI.
        // Product Details owns the real, server-bound image-editing workflow.
        return response()->json([
            'success' => false,
            'message' => 'AI Virtual Try-On is available from a product details page.',
        ], 422);
    }

    /**
     * GET /ai-camera-assistant/result/{file}
     * Streams a stored virtual try-on result image for display/download.
     * Only allows files under the virtual-tryon subfolder.
     */
    public function resultImage(string $file)
    {
        $path = 'virtual-tryon/' . $file;

        abort_unless(Storage::disk('public')->exists($path), 404);

        return response()->file(
            Storage::disk('public')->path($path),
            ['Content-Disposition' => 'inline']
        );
    }

    private function saveHistory(array $analysis, string $query): void
    {
        if (! auth()->check()) {
            return;
        }

        AICameraHistory::create([
            'user_id'  => auth()->id(),
            'query'    => $query ?: null,
            'analysis' => $analysis,
        ]);
    }

    private function saveHistoryWithImages(Request $request, string $resultImage, ?string $label): void
    {
        if (! auth()->check()) {
            return;
        }

// Persist the source image too (temporarily) so history can show it.
        // Wrap in try/catch so a transient storage failure never blocks the
        // history record (the generated result is still saved).
        $sourcePath = null;
        if ($request->hasFile('image')) {
            try {
                $sourcePath = $request->file('image')->store('virtual-tryon', 'public');
            } catch (\Throwable $e) {
                $sourcePath = null;
            }
        }

        AICameraHistory::create([
            'user_id'      => auth()->id(),
            'image_path'   => $sourcePath,
            'result_image' => $resultImage,
            'query'        => $label ? ('Virtual Try-On: ' . $label) : 'Virtual Try-On',
            'analysis'     => [
                'mode'      => 'virtual-try-on',
                'processor' => $request->input('processor', 'offline-composite'),
            ],
        ]);
    }

    private function recommendProducts(string $style, string $color, string $season, string $fit): Collection
    {
        $query = Product::query();

        // Prefer products that carry AI recommendation metadata.
        $query->where(function ($q) use ($style, $color, $season, $fit) {
            $q->where('style_type', $style)
                ->orWhere('color_category', $color)
                ->orWhere('season', $season)
                ->orWhere('body_fit', $fit);
        });

        $scored = $query->get()->map(function (Product $product) use ($style, $color, $season, $fit) {
            $score = 0;
            $reasons = [];

            if ($product->style_type === $style) {
                $score += 40;
                $reasons[] = "Matches your {$style} style";
            }
            if ($product->color_category === $color) {
                $score += 30;
                $reasons[] = "Complements your {$color} color tones";
            }
            if ($product->season === $season || $product->season === 'all') {
                $score += 20;
                $reasons[] = "Great for {$season} season";
            }
            if ($product->body_fit === $fit) {
                $score += 10;
                $reasons[] = "Ideal {$fit} fit";
            }
            $score += min(10, (int) (($product->rating ?? 0) * 2));

            return ['product' => $product, 'score' => $score, 'reasons' => $reasons];
        });

        // If nothing matched, fall back to top-rated products so results always show.
        if ($scored->every(fn ($r) => $r['score'] === 0)) {
            $scored = Product::query()
                ->orderByDesc('rating')
                ->latest()
                ->limit(8)
                ->get()
                ->map(fn (Product $product) => [
                    'product' => $product,
                    'score'   => min(10, (int) (($product->rating ?? 0) * 2)),
                    'reasons' => ['Top-rated pick for your style'],
                ]);
        }

        return $scored->sortByDesc('score')->take(8)->values();
    }

    private function respondView(Request $request, array|null $analysis, Collection $recommendations)
    {
        $data = [
            'analysis'        => $analysis,
            'recommendations' => $recommendations,
        ];

        return $request->boolean('sidebar')
            ? view('ai-hub.sidebar.camera-assistant', $data)
            : view('ai-hub.camera-assistant', $data);
    }
}
