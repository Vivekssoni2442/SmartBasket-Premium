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

        $products = Product::query()
            ->with('seller')
            ->where(
                fn ($query) =>
                    $query
                        ->whereNull('status')
                        ->orWhere('status', 'active')
            )
            ->latest()
            ->limit(8)
            ->get();

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

        $sellerProducts = Product::query()
            ->with('seller')
            ->where(function ($query) {

                $query
                    ->whereNull('status')
                    ->orWhere('status', 'active');

            })
            ->latest()
            ->get();


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

        $categories = Product::query()
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
        $product->load([
            'images',
            'seller',
        ]);


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

        $relatedProducts = Product::query()
            ->whereKeyNot($product->id)
            ->where(
                'category',
                $product->category
            )
            ->where(
                fn ($query) =>
                    $query
                        ->whereNull('status')
                        ->orWhere('status', 'active')
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