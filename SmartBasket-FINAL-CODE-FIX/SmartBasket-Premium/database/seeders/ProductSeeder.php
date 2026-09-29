<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Mobiles',
            'Laptops',
            'Fashion',
            'Beauty',
            'Home',
            'Kitchen',
            'Sports',
            'Books',
            'Accessories',
            'Grocery',
            'Furniture',
            'Toys'
        ];

        $products = [];

        for ($i = 1; $i <= 1200; $i++) {

            $category = $categories[array_rand($categories)];

            $products[] = [
                'name' => $this->generateName($category, $i),
                'category' => $category,
                'description' => "Premium quality {$category} product with modern features and best performance.",
                'image' => "https://picsum.photos/500/500?random=".$i,
                'price' => rand(99, 25000),
                'rating' => rand(35,50) / 10,
                'stock' => rand(20,300),
            ];
        }


        foreach ($products as $product) {

            Product::updateOrCreate(
                [
                    'name' => $product['name']
                ],
                $product
            );

        }


        echo "1200 Products Added Successfully!";
    }


    private function generateName($category, $number)
    {
        $names = [

            'Electronics' => [
                'Wireless Headphones',
                'Bluetooth Speaker',
                'Smart Watch',
                'Power Bank',
                'Gaming Mouse'
            ],

            'Mobiles' => [
                'Smartphone Pro',
                'Android Phone',
                '5G Mobile',
                'Premium Phone'
            ],

            'Laptops' => [
                'Gaming Laptop',
                'Business Laptop',
                'Ultra Notebook'
            ],

            'Fashion' => [
                'Premium T Shirt',
                'Jeans',
                'Shoes',
                'Jacket'
            ],

            'Beauty' => [
                'Face Cream',
                'Hair Serum',
                'Lipstick',
                'Perfume'
            ],

            'Home' => [
                'Wall Decor',
                'Lamp',
                'Bed Sheet',
                'Curtain'
            ],

            'Kitchen' => [
                'Mixer Grinder',
                'Cookware Set',
                'Bottle',
                'Storage Box'
            ],

            'Sports' => [
                'Football',
                'Cricket Bat',
                'Yoga Mat',
                'Gym Equipment'
            ],

            'Books' => [
                'Programming Book',
                'Business Book',
                'Novel',
                'Study Guide'
            ],

            'Accessories' => [
                'Wallet',
                'Bag',
                'Watch',
                'Mobile Cover'
            ],

            'Grocery' => [
                'Rice Pack',
                'Cooking Oil',
                'Snacks',
                'Spices'
            ],

            'Furniture' => [
                'Chair',
                'Table',
                'Sofa',
                'Bed'
            ],

            'Toys' => [
                'Kids Toy',
                'Puzzle Game',
                'Remote Car',
                'Learning Toy'
            ],
        ];


        $list = $names[$category];

        return $list[array_rand($list)] . " " . $number;
    }
}