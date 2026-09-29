<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiHubController extends Controller
{
    public function index()
    {
        return view('ai-hub.index');
    }

    public function camera(Request $request)
    {
        return $this->respond($request, 'camera', [
            'recommendations' => collect(),
        ], 'ai-hub.camera');
    }

    public function analyzeCamera(Request $request)
    {
        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // The image is intentionally validated but never stored. This keeps the
        // page ready for a future AI provider without changing product data.
        $recommendations = Product::query()
            ->orderByDesc('rating')
            ->latest()
            ->limit(8)
            ->get();

        return $this->respond($request, 'camera', compact('recommendations'), 'ai-hub.camera')
            ->with('success', 'Image received. AI recommendations are ready for future integration.');
    }

    public function budget(Request $request)
    {
        $budget = $request->input('budget');
        $products = collect();

        if ($budget !== null && $budget !== '') {
            $validated = $request->validate(['budget' => 'numeric|min:0']);
            $budget = $validated['budget'];
            $products = Product::query()->where('price', '<=', $budget)->orderByDesc('rating')->get();
        }

        return $this->respond($request, 'budget', compact('budget', 'products'), 'ai-hub.budget');
    }

    public function giftFinder(Request $request)
    {
        $occasion = $request->input('occasion');
        $products = collect();

        if ($occasion) {
            $keywords = [
                'Birthday' => ['gift', 'toy', 'fashion', 'accessor'],
                'Anniversary' => ['gift', 'fashion', 'jewellery', 'beauty'],
                'Festival' => ['festival', 'decor', 'fashion', 'food'],
            ][$occasion] ?? [];

            $products = Product::query()
                ->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->orWhere('category', 'like', '%' . $keyword . '%')
                            ->orWhere('name', 'like', '%' . $keyword . '%');
                    }
                })
                ->orderByDesc('rating')
                ->get();

            if ($products->isEmpty()) {
                $products = Product::query()->orderByDesc('rating')->latest()->limit(12)->get();
            }
        }

        return $this->respond($request, 'gift-finder', compact('occasion', 'products'), 'ai-hub.gift-finder');
    }

    public function trending(Request $request)
    {
        $products = Product::all();
        $sales = [];

        foreach (Order::query()->whereNotNull('items')->get() as $order) {
            foreach ((array) $order->items as $item) {
                $id = $item['product_id'] ?? null;
                if ($id) {
                    $sales[$id] = ($sales[$id] ?? 0) + (int) ($item['quantity'] ?? 1);
                }
            }
        }

        $trendingProducts = $products->sortByDesc(function ($product) use ($sales) {
            return ($sales[$product->id] ?? 0) * 1000 + (float) ($product->rating ?? 0);
        })->values();

        return $this->respond($request, 'trending', compact('trendingProducts', 'sales'), 'ai-hub.trending');
    }

    public function compare(Request $request)
    {
        $products = Product::query()->orderBy('name')->get();
        $selectedIds = $request->validate([
            'product_one' => 'nullable|integer|exists:products,id',
            'product_two' => 'nullable|integer|exists:products,id|different:product_one',
        ]);

        $firstProduct = isset($selectedIds['product_one']) ? $products->firstWhere('id', $selectedIds['product_one']) : null;
        $secondProduct = isset($selectedIds['product_two']) ? $products->firstWhere('id', $selectedIds['product_two']) : null;

        return $this->respond($request, 'compare', compact('products', 'firstProduct', 'secondProduct'), 'ai-hub.compare');
    }

    public function wishlist(Request $request)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $wishlistItems = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();

        return $this->respond($request, 'wishlist', compact('wishlistItems'), 'ai-hub.wishlist');
    }

    public function removeWishlist(Wishlist $wishlist)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        abort_unless($wishlist->user_id === Auth::id(), 403);
        $wishlist->delete();

        return back()->with('success', 'Item removed from wishlist.');
    }
    public function aiChat(Request $request)
{
    $request->validate([
        'message' => 'required|string'
    ]);

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . config('services.groq.key'),
        'Content-Type' => 'application/json',
    ])->post('https://api.groq.com/openai/v1/chat/completions', [

        'model' => 'llama-3.1-8b-instant',

        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are Smart Basket AI shopping assistant. Help users with product recommendations.'
            ],
            [
                'role' => 'user',
                'content' => $request->message
            ]
        ],

        'temperature' => 0.7
    ]);

    if ($response->failed()) {
        return response()->json([
            'error' => 'Groq API Error',
            'details' => $response->json()
        ], 500);
    }

    return response()->json([
        'reply' => $response['choices'][0]['message']['content']
    ]);
}
    private function respond(Request $request, string $panel, array $data, string $page)
    {
        return $request->boolean('sidebar')
            ? view('ai-hub.sidebar.' . $panel, $data)
            : view($page, $data);
    }
}
