<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;

class CustomerAiTools
{
    public function __construct(private CustomerAiWebSearch $webSearch)
    {
    }

    public function definitions(): array
    {
        return [

            $this->definition(
                'search_products',
                'Search active Smart Basket products using a customer request.',
                [
                    'query' => [
                        'type' => 'string',
                        'description' => 'Product name, category, keyword, or shopping request.',
                    ],
                    'max_price' => [
                        'type' => 'number',
                        'description' => 'Maximum effective product price.',
                    ],
                    'min_price' => [
                        'type' => 'number',
                        'description' => 'Minimum effective product price.',
                    ],
                    'in_stock' => [
                        'type' => 'boolean',
                        'description' => 'Set true to return products with confirmed positive stock only.',
                    ],
                    'sort' => [
                        'type' => 'string',
                        'enum' => ['price_asc', 'price_desc', 'newest'],
                    ],
                ]
            ),

            $this->definition(
                'web_search',
                'Search the configured live web provider and return sourced results. Use only when live/current external information is requested.',
                [
                    'query' => [
                        'type' => 'string',
                        'description' => 'A concise public query only. Never include customer identifiers, account details, addresses, orders, or payment information.',
                    ],
                    'topic' => [
                        'type' => 'string',
                        'enum' => ['general', 'news'],
                        'description' => 'Use news for current news coverage; otherwise use general.',
                    ],
                ],
                ['query']
            ),

            $this->definition(
                'get_product_details',
                'Get safe public details for one active product.',
                [
                    'product_id' => [
                        'type' => 'integer',
                    ],
                ],
                ['product_id']
            ),

            $this->definition(
                'compare_products',
                'Compare two to four active Smart Basket products using their actual stored details.',
                [
                    'product_ids' => [
                        'type' => 'array',
                        'minItems' => 2,
                        'maxItems' => 4,
                        'items' => ['type' => 'integer'],
                    ],
                ],
                ['product_ids']
            ),

            $this->definition(
                'open_product_page',
                'Open an active product in the Smart Basket customer storefront.',
                ['product_id' => ['type' => 'integer']],
                ['product_id']
            ),

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            | Empty tool parameters must still be a JSON object.
            */

            $this->definition(
                'get_visible_products',
                'Get the products currently visible on the customer Products page.',
                [
                    '_dummy' => [
                        'type' => 'string',
                        'description' => 'Do not use. Internal schema placeholder.',
                    ],
                ]
            ),

            $this->definition(
                'get_cart',
                'Get the authenticated customer’s own cart summary and items.',
                [
                    '_dummy' => [
                        'type' => 'string',
                        'description' => 'Do not use. Internal schema placeholder.',
                    ],
                ]
            ),

            $this->definition(
                'get_wishlist',
                'Get the authenticated customer’s own wishlist.',
                ['_dummy' => ['type' => 'string']]
            ),

            $this->definition(
                'add_to_wishlist',
                'Add an active product to the authenticated customer’s wishlist.',
                ['product_id' => ['type' => 'integer']],
                ['product_id']
            ),

            $this->definition(
                'remove_from_wishlist',
                'Remove a product from the authenticated customer’s own wishlist.',
                ['wishlist_item_id' => ['type' => 'integer']],
                ['wishlist_item_id']
            ),

            $this->definition(
                'add_to_cart',
                'Add an active product to the authenticated customer’s cart.',
                [
                    'product_id' => [
                        'type' => 'integer',
                    ],
                    'quantity' => [
                        'type' => 'integer',
                        'minimum' => 1,
                        'maximum' => 10,
                    ],
                ],
                ['product_id']
            ),

            $this->definition(
                'remove_cart_item',
                'Remove one item from the authenticated customer’s own cart.',
                [
                    'cart_item_id' => [
                        'type' => 'integer',
                    ],
                ],
                ['cart_item_id']
            ),

            $this->definition(
                'update_cart_quantity',
                'Set quantity for one item in the authenticated customer’s own cart.',
                [
                    'cart_item_id' => [
                        'type' => 'integer',
                    ],
                    'quantity' => [
                        'type' => 'integer',
                        'minimum' => 1,
                        'maximum' => 10,
                    ],
                ],
                ['cart_item_id', 'quantity']
            ),

            $this->definition(
                'get_customer_orders',
                'Get only the authenticated customer’s recent orders.',
                [
                    'limit' => [
                        'type' => 'integer',
                        'minimum' => 1,
                        'maximum' => 5,
                    ],
                ]
            ),

            $this->definition(
                'get_customer_order_details',
                'Get details for one order belonging to the authenticated customer only.',
                ['order_id' => ['type' => 'integer']],
                ['order_id']
            ),

            $this->definition(
                'get_customer_profile',
                'Show the authenticated customer their own basic profile contact information.',
                ['_dummy' => ['type' => 'string']]
            ),

            $this->definition(
                'navigate_customer_page',
                'Navigate the customer to one allowed Smart Basket page.',
                [
                    'destination' => [
                        'type' => 'string',
                        'enum' => [
                            'home',
                            'back',
                            'forward',
                            'products',
                            'cart',
                            'checkout',
                            'orders',
                            'wishlist',
                            'profile',
                            'addresses',
                            'settings',
                            'payments',
                        ],
                    ],
                ],
                ['destination']
            ),

            $this->definition(
                'set_customer_theme',
                'Switch the customer’s existing Smart Basket theme.',
                [
                    'theme' => [
                        'type' => 'string',
                        'enum' => [
                            'light',
                            'dark',
                            'system',
                        ],
                    ],
                ],
                ['theme']
            ),

            $this->definition(
                'robot_gesture',
                'Trigger a predefined visual Smart AI robot gesture.',
                [
                    'gesture' => [
                        'type' => 'string',
                        'enum' => [
                            'dance',
                            'wave',
                            'smile',
                            'laughing',
                            'jump',
                            'celebrate',
                            'sleep',
                            'wake',
                            'singing',
                        ],
                    ],
                ],
                ['gesture']
            ),
        ];
    }

    public function execute(
        string $tool,
        array $arguments,
        User $customer,
        array $context
    ): array {
        return match ($tool) {

            'search_products'
                => $this->searchProducts($arguments),

            'web_search'
                => $this->webSearch->search(
                    (string) ($arguments['query'] ?? ''),
                    (string) ($arguments['topic'] ?? 'general')
                ),

            'get_product_details'
                => $this->productDetails($arguments),

            'compare_products'
                => $this->compareProducts($arguments),

            'open_product_page'
                => $this->openProductPage($arguments),

            'get_visible_products'
                => $this->visibleProducts($context),

            'get_cart'
                => $this->cart($customer),

            'get_wishlist'
                => $this->wishlist($customer),

            'add_to_wishlist'
                => $this->addToWishlist($arguments, $customer),

            'remove_from_wishlist'
                => $this->removeFromWishlist($arguments, $customer),

            'add_to_cart'
                => $this->addToCart($arguments, $customer),

            'remove_cart_item'
                => $this->removeCartItem($arguments, $customer),

            'update_cart_quantity'
                => $this->updateCartQuantity($arguments, $customer),

            'get_customer_orders'
                => $this->orders($arguments, $customer),

            'get_customer_order_details'
                => $this->orderDetails($arguments, $customer),

            'get_customer_profile'
                => $this->customerProfile($customer),

            'navigate_customer_page'
                => $this->navigate($arguments),

            'set_customer_theme'
                => $this->theme($arguments),

            'robot_gesture'
                => $this->gesture($arguments),

            default => [
                'ok' => false,
                'message' => 'This tool is not available.',
            ],
        };
    }

    private function searchProducts(array $args): array
    {
        $query = trim((string) ($args['query'] ?? ''));

        $maxPrice = isset($args['max_price'])
            ? max(0, (float) $args['max_price'])
            : null;
        $minPrice = isset($args['min_price'])
            ? max(0, (float) $args['min_price'])
            : null;

        $products = Product::query()->customerVisible()
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', 'active');
            });

        if ($query !== '') {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%")
                    ->orWhere('brand', 'like', "%{$query}%")
                    ->orWhere('size', 'like', "%{$query}%")
                    ->orWhere('color', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }

        // Product prices are stored as decimal strings on supported database
        // drivers; cast explicitly so range comparisons remain numeric.
        $effectivePriceSql = 'CAST(CASE WHEN discount_price IS NOT NULL '
            .'AND CAST(discount_price AS DECIMAL(12,2)) >= 0 '
            .'AND CAST(discount_price AS DECIMAL(12,2)) < CAST(price AS DECIMAL(12,2)) '
            .'THEN discount_price ELSE price END AS DECIMAL(12,2))';

        if ($maxPrice !== null) {
            $products->whereRaw($effectivePriceSql.' <= ?', [$maxPrice]);
        }

        if ($minPrice !== null) {
            $products->whereRaw($effectivePriceSql.' >= ?', [$minPrice]);
        }

        if (($args['in_stock'] ?? false) === true) {
            $products->where('stock', '>', 0);
        }

        match ($args['sort'] ?? 'newest') {
            'price_asc' => $products->orderByRaw($effectivePriceSql.' ASC'),
            'price_desc' => $products->orderByRaw($effectivePriceSql.' DESC'),
            default => $products->latest(),
        };

        $resultLimit = max(1, min(12, (int) config('services.customer_ai.product_results', 6)));
        $results = $products
            ->limit($resultLimit)
            ->get([
                'id',
                'name',
                'category',
                'price',
                'discount_price',
                'rating',
                'stock',
                'brand',
                'size',
                'color',
                'description',
                'image',
            ]);

        $formatted = $results
            ->map(fn (Product $product) => $this->product($product))
            ->values()
            ->all();

        return [
            'ok' => true,
            'count' => count($formatted),
            'products' => $formatted,

            'action' => [
                'type' => 'recommendations',
                'products' => $formatted,
            ],
        ];
    }

    private function productDetails(array $args): array
    {
        $product = $this->activeProduct(
            (int) ($args['product_id'] ?? 0)
        );

        if (! $product) {
            return [
                'ok' => false,
                'message' => 'That product is not available.',
            ];
        }

        return [
            'ok' => true,
            'product' => $this->product($product, true),
        ];
    }

    private function compareProducts(array $args): array
    {
        $ids = collect($args['product_ids'] ?? [])
            ->map(fn ($id) => filter_var($id, FILTER_VALIDATE_INT))
            ->filter(fn ($id) => $id !== false && $id > 0)
            ->unique()
            ->take(4)
            ->values();

        if ($ids->count() < 2) {
            return ['ok' => false, 'message' => 'Choose at least two available products to compare.'];
        }

        $products = Product::query()->customerVisible()
            ->whereIn('id', $ids)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 'active');
            })
            ->get()
            ->keyBy('id');

        $ordered = $ids->map(fn ($id) => $products->get($id))->filter();
        if ($ordered->count() < 2) {
            return ['ok' => false, 'message' => 'At least two of those products are no longer available.'];
        }

        $formatted = $ordered->map(fn (Product $product) => $this->product($product, true))->values()->all();

        return [
            'ok' => true,
            'products' => $formatted,
            'action' => ['type' => 'recommendations', 'products' => $formatted],
        ];
    }

    private function openProductPage(array $args): array
    {
        $product = $this->activeProduct((int) ($args['product_id'] ?? 0));
        if (! $product) {
            return ['ok' => false, 'message' => 'That product is not available.'];
        }

        return [
            'ok' => true,
            'action' => ['type' => 'open_product', 'product_id' => $product->id],
        ];
    }

    private function visibleProducts(array $context): array
    {
        $ids = collect($context['visible_product_ids'] ?? [])
            ->map(fn ($id) => filter_var($id, FILTER_VALIDATE_INT))
            ->filter()
            ->take(12)
            ->values();

        if ($ids->isEmpty()) {
            return [
                'ok' => true,
                'products' => [],
                'message' => 'No products are currently visible.',
            ];
        }

        $products = Product::query()->customerVisible()
            ->whereIn('id', $ids)
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', 'active');
            })
            ->get();

        return [
            'ok' => true,
            'products' => $products
                ->map(fn (Product $product) => $this->product($product))
                ->values()
                ->all(),
        ];
    }

    private function cart(User $customer): array
    {
        $items = Cart::with('product')
            ->where('user_id', $customer->id)
            ->get()
            ->filter(fn (Cart $item) => $item->product);

        return [
            'ok' => true,

            'item_count' => $items->sum('quantity'),

            'subtotal' => round(
                $items->sum(
                    fn (Cart $item) =>
                        (float) $item->product->effective_price * $item->quantity
                ),
                2
            ),

            'items' => $items
                ->map(fn (Cart $item) => [
                    'cart_item_id' => $item->id,
                    'quantity' => $item->quantity,
                    'product' => $this->product($item->product),
                ])
                ->values()
                ->all(),
        ];
    }

    private function wishlist(User $customer): array
    {
        $products = Wishlist::with('product')
            ->where('user_id', $customer->id)
            ->latest()
            ->limit(20)
            ->get()
            ->filter(fn (Wishlist $item) => $item->product && $this->isActive($item->product));

        return [
            'ok' => true,
            'count' => $products->count(),
            'items' => $products->map(fn (Wishlist $item) => [
                'wishlist_item_id' => $item->id,
                'product' => $this->product($item->product),
            ])->values()->all(),
        ];
    }

    private function addToWishlist(array $args, User $customer): array
    {
        $product = $this->activeProduct((int) ($args['product_id'] ?? 0));
        if (! $product) {
            return ['ok' => false, 'message' => 'That product is not available.'];
        }

        $item = Wishlist::firstOrCreate([
            'user_id' => $customer->id,
            'product_id' => $product->id,
        ]);

        return [
            'ok' => true,
            'message' => $item->wasRecentlyCreated ? 'Product added to your wishlist.' : 'Product is already in your wishlist.',
            'wishlist_item_id' => $item->id,
        ];
    }

    private function removeFromWishlist(array $args, User $customer): array
    {
        $item = Wishlist::whereKey((int) ($args['wishlist_item_id'] ?? 0))
            ->where('user_id', $customer->id)
            ->first();
        if (! $item) {
            return ['ok' => false, 'message' => 'That wishlist item was not found.'];
        }

        $item->delete();

        return ['ok' => true, 'message' => 'Product removed from your wishlist.'];
    }

    private function addToCart(
        array $args,
        User $customer
    ): array {
        $product = $this->activeProduct(
            (int) ($args['product_id'] ?? 0)
        );

        $rawQuantity = $args['quantity'] ?? 1;
        $quantity = filter_var($rawQuantity, FILTER_VALIDATE_INT);

        if ($quantity === false || $quantity < 1 || $quantity > 10) {
            return ['ok' => false, 'message' => 'Choose a quantity from 1 to 10.'];
        }

        if (! $product || ($product->stock !== null && (int) $product->stock < 1)) {
            return [
                'ok' => false,
                'message' => 'That product is not available.',
            ];
        }

        $item = Cart::firstOrNew([
            'user_id' => $customer->id,
            'product_id' => $product->id,
        ]);

        $newQuantity =
            ($item->exists ? (int) $item->quantity : 0)
            + $quantity;

        if (
            $product->stock !== null &&
            $newQuantity > (int) $product->stock
        ) {
            return [
                'ok' => false,
                'message' => 'The requested quantity is not in stock.',
            ];
        }

        $item->quantity = $newQuantity;
        $item->save();

        return [
            'ok' => true,
            'message' => "{$product->name} was added to your cart.",
            'cart_item_id' => $item->id,

            'action' => [
                'type' => 'add_to_cart',
                'product_id' => $product->id,
            ],
        ];
    }

    private function removeCartItem(
        array $args,
        User $customer
    ): array {
        $item = Cart::with('product')
            ->whereKey((int) ($args['cart_item_id'] ?? 0))
            ->where('user_id', $customer->id)
            ->first();

        if (! $item) {
            return [
                'ok' => false,
                'message' => 'That cart item was not found.',
            ];
        }

        $name = $item->product?->name ?? 'The item';

        $item->delete();

        return [
            'ok' => true,
            'message' => "{$name} was removed from your cart.",

            'action' => [
                'type' => 'remove_cart_item',
                'cart_item_id' => $item->id,
            ],
        ];
    }

    private function updateCartQuantity(
        array $args,
        User $customer
    ): array {
        $item = Cart::with('product')
            ->whereKey((int) ($args['cart_item_id'] ?? 0))
            ->where('user_id', $customer->id)
            ->first();

        $quantity = filter_var($args['quantity'] ?? null, FILTER_VALIDATE_INT);

        if ($quantity === false || $quantity < 1 || $quantity > 10) {
            return ['ok' => false, 'message' => 'Choose a quantity from 1 to 10.'];
        }

        if (! $item || ! $item->product) {
            return [
                'ok' => false,
                'message' => 'That cart item was not found.',
            ];
        }

        if (
            $item->product->stock !== null &&
            $quantity > (int) $item->product->stock
        ) {
            return [
                'ok' => false,
                'message' => 'That quantity is not in stock.',
            ];
        }

        $item->update([
            'quantity' => $quantity,
        ]);

        return [
            'ok' => true,
            'message' => "Quantity for {$item->product->name} is now {$quantity}.",

            'action' => [
                'type' => 'update_cart_quantity',
                'cart_item_id' => $item->id,
                'quantity' => $quantity,
            ],
        ];
    }

    private function orders(
        array $args,
        User $customer
    ): array {
        $limit = max(
            1,
            min(5, (int) ($args['limit'] ?? 3))
        );

        $orders = Order::where(
            'user_id',
            $customer->id
        )
            ->latest()
            ->limit($limit)
            ->get([
                'id',
                'total',
                'status',
                'order_status',
                'delivery_status',
                'created_at',
            ]);

        return [
            'ok' => true,
            'count' => $orders->count(),

            'orders' => $orders
                ->map(fn (Order $order) => [
                    'id' => $order->id,
                    'total' => (float) $order->total,
                    'status' =>
                        $order->delivery_status
                        ?? $order->order_status
                        ?? $order->status
                        ?? 'Processing',
                    'placed_at' =>
                        $order->created_at?->toDateString(),
                    'url' => route('orders.show', $order),
                ])
                ->values()
                ->all(),
        ];
    }

    private function orderDetails(array $args, User $customer): array
    {
        $order = Order::query()
            ->where('user_id', $customer->id)
            ->whereKey((int) ($args['order_id'] ?? 0))
            ->first();

        if (! $order) {
            return ['ok' => false, 'message' => 'That order was not found in your account.'];
        }

        return [
            'ok' => true,
            'order' => [
                'id' => $order->id,
                'total' => (float) ($order->total ?? $order->amount ?? 0),
                'status' => $order->delivery_status ?? $order->order_status ?? $order->status ?? 'Processing',
                'placed_at' => $order->created_at?->toDateString(),
                'items' => collect($order->items ?? [])->map(fn ($item) => [
                    'name' => (string) ($item['name'] ?? $item['product_name'] ?? 'Product'),
                    'quantity' => max(1, (int) ($item['quantity'] ?? 1)),
                    'price' => (float) ($item['price'] ?? 0),
                ])->take(20)->values()->all(),
                'url' => route('orders.show', $order),
            ],
        ];
    }

    private function customerProfile(User $customer): array
    {
        return [
            'ok' => true,
            'profile' => [
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'url' => route('profile'),
            ],
        ];
    }

    private function navigate(array $args): array
    {
        $destination = $args['destination'] ?? '';

        if (! in_array(
            $destination,
            [
                'home',
                'back',
                'forward',
                'products',
                'cart',
                'checkout',
                'orders',
                'wishlist',
                'profile',
                'addresses',
                'settings',
                'payments',
            ],
            true
        )) {
            return [
                'ok' => false,
                'message' => 'That destination is unavailable.',
            ];
        }

        return [
            'ok' => true,

            'action' => [
                'type' => 'navigate',
                'destination' => $destination,
            ],
        ];
    }

    private function theme(array $args): array
    {
        $theme = $args['theme'] ?? '';

        if (! in_array(
            $theme,
            ['light', 'dark', 'system'],
            true
        )) {
            return [
                'ok' => false,
                'message' => 'That theme is unavailable.',
            ];
        }

        return [
            'ok' => true,

            'action' => [
                'type' => 'theme',
                'theme' => $theme,
            ],
        ];
    }

    private function gesture(array $args): array
    {
        $gesture = $args['gesture'] ?? '';

        if (! in_array(
            $gesture,
            [
                'dance',
                'wave',
                'smile',
                'laughing',
                'jump',
                'celebrate',
                'sleep',
                'wake',
                'singing',
            ],
            true
        )) {
            return [
                'ok' => false,
                'message' => 'That gesture is unavailable.',
            ];
        }

        return [
            'ok' => true,

            'action' => [
                'type' => 'gesture',
                'gesture' => $gesture,
            ],
        ];
    }

    private function activeProduct(int $id): ?Product
    {
        return Product::query()->customerVisible()
            ->whereKey($id)
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', 'active');
            })
            ->first();
    }

    private function isActive(Product $product): bool
    {
        return $product->status === null || $product->status === 'active';
    }

    private function product(
        Product $product,
        bool $details = false
    ): array {
        return array_filter(
            [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'price' => number_format((float) $product->effective_price, 2, '.', ''),
                'url' => route('products.show', $product),
                'image_url' => $product->image ? asset('products/' . ltrim($product->image, '/')) : null,
                'brand' => $product->brand,
                'size' => $product->size,
                'color' => $product->color,
                'rating' => (float) $product->rating,
                'stock' => $product->stock === null ? null : (int) $product->stock,
                'description' =>
                    $product->description,
            ],
            fn ($value) => $value !== null
        );
    }

    private function definition(
        string $name,
        string $description,
        array $properties,
        array $required = []
    ): array {
        return [
            'type' => 'function',

            'function' => [
                'name' => $name,
                'description' => $description,

                'parameters' => [
                    'type' => 'object',
                    'properties' => $properties,
                    'required' => $required,
                    'additionalProperties' => false,
                ],
            ],
        ];
    }
}
