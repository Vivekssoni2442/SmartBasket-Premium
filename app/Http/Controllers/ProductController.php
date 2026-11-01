<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $catalog = Product::query()->customerVisible()
            ->with('seller')
            ->latest()
            ->limit(80)
            ->get();

        // Spread the home recommendations across stores so one busy seller
        // does not occupy every featured slot.
        $storeGroups = $catalog->groupBy(fn ($product) => $product->seller_id ?: 'platform')
            ->map(fn ($storeProducts) => $storeProducts->take(2));
        $products = $storeGroups->flatten(1)->sortByDesc('created_at')->take(8)->values();
        if ($products->count() < 8) {
            $products = $products->concat(
                $catalog->whereNotIn('id', $products->pluck('id'))
                    ->take(8 - $products->count())
            )->values();
        }

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.for-you', [
            'user' => $user,
            'products' => $products,
            'orders' => $orders,
            'cartCount' => Cart::where(
                'user_id',
                $user->id
            )->sum('quantity'),

            'wishlistCount' => Wishlist::where(
                'user_id',
                $user->id
            )->count(),

            'orderCount' => Order::where(
                'user_id',
                $user->id
            )->count(),
        ]);
    }


    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CUSTOMER LOGIN WELCOME ANIMATION
        |--------------------------------------------------------------------------
        |
        | The login route creates this one-time session flag.
        |
        | pull() reads the value and immediately removes it from the session.
        |
        | Therefore:
        |
        | Login → Products → Welcome
        | Refresh Products → No Welcome
        | Direct Products visit → No Welcome
        |
        |--------------------------------------------------------------------------
        */

        $showWelcome = session()->pull(
            'customer_login_welcome',
            false
        );


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER PRODUCT CATALOG
        |--------------------------------------------------------------------------
        |
        | Customer catalog remains global.
        | Seller ownership is enforced only in seller queries.
        |--------------------------------------------------------------------------
        */

        $sellerProducts = Product::query()->customerVisible()
            ->with('seller')
            ->latest()
            ->get();

        $sellerId = $request->integer('seller') ?: null;
        $sellers = $sellerProducts
            ->pluck('seller')
            ->filter()
            ->unique('id')
            ->sortBy(fn ($seller) => mb_strtolower($seller->shop_name ?: $seller->seller_name ?: ''))
            ->values();


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $search = trim(
            (string) $request->get('search', '')
        );


        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        $category = trim(
            (string) $request->get('category', '')
        );


        /*
        |--------------------------------------------------------------------------
        | APPLY SEARCH FILTER
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $sellerProducts = $sellerProducts
                ->filter(function ($product) use ($search) {

                    return stripos(
                        $product->name,
                        $search
                    ) !== false

                    ||

                    stripos(
                        $product->category,
                        $search
                    ) !== false;

                })
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | APPLY CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        if ($category !== '') {

            $sellerProducts = $sellerProducts
                ->filter(function ($product) use ($category) {

                    return strcasecmp(
                        $product->category,
                        $category
                    ) === 0;

                })
                ->values();
        }

        if ($sellerId) {
            $sellerProducts = $sellerProducts
                ->where('seller_id', $sellerId)
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $perPage = 8;

        $page = max(
            1,
            (int) $request->get('page', 1)
        );


        $pagedProducts = new LengthAwarePaginator(
            $sellerProducts
                ->slice(
                    ($page - 1) * $perPage,
                    $perPage
                )
                ->values(),

            $sellerProducts->count(),

            $perPage,

            $page,

            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Product::query()->customerVisible()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS VIEW
        |--------------------------------------------------------------------------
        |
        | $showWelcome tells the Products Blade whether the premium
        | welcome animation should be displayed.
        |--------------------------------------------------------------------------
        */

        return view(
            'products.index',
            compact(
                'pagedProducts',
                'categories',
                'search',
                'category',
                'sellerId',
                'sellers',
                'showWelcome'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT DETAILS
    |--------------------------------------------------------------------------
    */

    /** Display the selected real product with its own images and seller. */
    public function show(Product $product)
    {
        // Apply the exact same seller visibility rules as the customer catalog.
        abort_unless(
            Product::query()->customerVisible()->whereKey($product->getKey())->exists(),
            404
        );

        $product->load([
            'images',
            'videos',
            'seller',
        ]);
        abort_if($product->seller_id && (! $product->seller || ! $product->seller->isStoreVisibleToCustomers()), 404);


        /*
        |--------------------------------------------------------------------------
        | RECENTLY VIEWED PRODUCT
        |--------------------------------------------------------------------------
        */

        if (auth()->check()) {

            \App\Models\RecentlyViewedProduct::firstOrCreate([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | RELATED PRODUCTS
        |--------------------------------------------------------------------------
        */

        $relatedProducts = Product::query()->customerVisible()
            ->whereKeyNot($product->id)
            ->where(
                'category',
                $product->category
            )
            ->latest()
            ->limit(4)
            ->get();


        return view(
            'products.show',
            compact(
                'product',
                'relatedProducts'
            )
        );
    }
}
