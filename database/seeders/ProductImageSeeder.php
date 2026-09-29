<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {

        $images = [

            'Headphones' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',

            'Speaker' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',

            'Watch' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',

            'Power Bank' => 'https://images.unsplash.com/photo-1609592424891-1a4f3c2c8e1e?w=500',

            'Earbuds' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a445?w=500',

            'Camera' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500',

            'Keyboard' => 'https://images.unsplash.com/photo-1587829744716-3a73c2fc3e1c?w=500',

            'Mouse' => 'https://images.unsplash.com/photo-1527814050087-3796a4903c57?w=500',

            'Laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500',

            'Shoes' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',

            'T-Shirt' => 'https://images.unsplash.com/photo-1617127365659-c47fa864d8bc?w=500',

            'Book' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=500',

            'Phone' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500',

            'Bag' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500',

        ];


        foreach(Product::all() as $product)
        {

            foreach($images as $key=>$image)
            {

                if(str_contains($product->name,$key))
                {
                    $product->update([
                        'image'=>$image
                    ]);

                    break;
                }

            }

        }

    }
}