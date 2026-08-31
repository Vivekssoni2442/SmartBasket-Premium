<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class CustomerAiTools
{
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
                        'description' => 'Maximum product price.',
                    ],
                    'sort' => [
                        'type' => 'string',
                        'enum' => ['price_asc', 'price_desc', 'newest'],
                    ],
                ]
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
                'navigate_customer_page',
                'Navigate the customer to one allowed Smart Basket page.',
                [
                    'destination' => [
                        'type' => 'string',
                        'enum' => [
                            'products',
                            'cart',
                            'checkout',
                            'orders',
                            'settings',
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

            'get_product_details'
                => $this->productDetails($arguments),

            'get_visible_products'
                => $this->visibleProducts($context),

            'get_cart'
                => $this->cart($customer),

            'add_to_cart'
                => $this->addToCart($arguments, $customer),

            'remove_cart_item'
                => $this->removeCartItem($arguments, $customer),

            'update_cart_quantity'
                => $this->updateCartQuantity($arguments, $customer),

            'get_customer_orders'
                => $this->orders($arguments, $customer),

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

        $products = Product::query()
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', 'active');
            });

        if ($query !== '') {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($maxPrice !== null) {
            $products->where('price', '<=', $maxPrice);
        }

        match ($args['sort'] ?? 'newest') {
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            default => $products->latest(),
        };

        $results = $products
            ->limit(6)
            ->get([
                'id',
                'name',
                'category',
                'price',
                'discount_price',
                'rating',
                'stock',
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

        $products = Product::query()
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
                        (float) $item->product->price * $item->quantity
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

    private function addToCart(
        array $args,
        User $customer
    ): array {
        $product = $this->activeProduct(
            (int) ($args['product_id'] ?? 0)
        );

        $quantity = max(
            1,
            min(10, (int) ($args['quantity'] ?? 1))
        );

        if (! $product) {
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

        $quantity = max(
            1,
            min(10, (int) ($args['quantity'] ?? 1))
        );

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
                ])
                ->values()
                ->all(),
        ];
    }

    private function navigate(array $args): array
    {
        $destination = $args['destination'] ?? '';

        if (! in_array(
            $destination,
            [
                'products',
                'cart',
                'checkout',
                'orders',
                'settings',
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
        return Product::query()
            ->whereKey($id)
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', 'active');
            })
            ->first();
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
                'price' => (float) (
                    $product->discount_price ?: $product->price
                ),
                'rating' => (float) $product->rating,
                'stock' => (int) $product->stock,
                'description' =>
                    $details
                    ? $product->description
                    : null,
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