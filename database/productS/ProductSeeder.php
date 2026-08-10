<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
$productImages = [

'Wireless Headphones'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',

'Bluetooth Speaker'=>'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',

'Smart Watch'=>'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',

'Gaming Mouse'=>'https://images.unsplash.com/photo-1527814050087-3793815479db?w=500',

'Laptop Stand'=>'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500',

'Men Cotton Shirt'=>'https://images.unsplash.com/photo-1617127365659-c47fa864d8bc?w=500',

'Men Jeans'=>'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500',

'Women Kurti'=>'https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=500',

'Sports Shoes'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',

'Perfume'=>'https://images.unsplash.com/photo-1541643600914-78b084683601?w=500',

'Face Wash'=>'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=500',

'Mixer Grinder'=>'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500',

'Football'=>'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=500',

'Programming Book'=>'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=500',

'Backpack'=>'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500'

];
        $products = [

            // Electronics
            ['Wireless Headphones','Electronics',1999],
            ['Bluetooth Speaker','Electronics',1499],
            ['Smart Watch','Electronics',2999],
            ['Gaming Mouse','Electronics',899],
            ['Mechanical Keyboard','Electronics',2499],
            ['Laptop Stand','Electronics',799],
            ['Power Bank 20000mAh','Electronics',1299],
            ['USB Type C Cable','Electronics',399],
            ['Mobile Charger','Electronics',599],
            ['LED Monitor','Electronics',8999],

            // Fashion
            ['Men Cotton Shirt','Fashion',799],
            ['Men Jeans','Fashion',1199],
            ['Women Kurti','Fashion',999],
            ['Women Saree','Fashion',1499],
            ['Sports Shoes','Fashion',2499],
            ['Casual Shoes','Fashion',1799],
            ['Leather Wallet','Fashion',599],
            ['Hand Bag','Fashion',899],
            ['Sunglasses','Fashion',499],
            ['Wrist Watch','Fashion',1999],

            // Beauty
            ['Face Wash','Beauty',299],
            ['Moisturizer','Beauty',499],
            ['Perfume','Beauty',999],
            ['Hair Shampoo','Beauty',399],
            ['Hair Oil','Beauty',299],
            ['Lip Balm','Beauty',199],
            ['Skin Cream','Beauty',599],
            ['Makeup Kit','Beauty',1499],
            ['Body Lotion','Beauty',399],
            ['Face Serum','Beauty',799],

            // Home
            ['LED Bulb','Home',199],
            ['Table Lamp','Home',799],
            ['Wall Clock','Home',599],
            ['Bedsheet','Home',999],
            ['Pillow Set','Home',699],
            ['Curtains','Home',1299],
            ['Carpet','Home',1999],
            ['Sofa Cover','Home',899],
            ['Storage Box','Home',499],
            ['Mirror','Home',799],

            // Kitchen
            ['Mixer Grinder','Kitchen',2999],
            ['Electric Kettle','Kitchen',999],
            ['Non Stick Pan','Kitchen',899],
            ['Pressure Cooker','Kitchen',1499],
            ['Dinner Set','Kitchen',1999],
            ['Water Bottle','Kitchen',399],
            ['Coffee Mug','Kitchen',299],
            ['Knife Set','Kitchen',699],
            ['Lunch Box','Kitchen',499],
            ['Toaster','Kitchen',1299],

            // Sports
            ['Cricket Bat','Sports',1999],
            ['Football','Sports',699],
            ['Badminton Racket','Sports',1299],
            ['Yoga Mat','Sports',599],
            ['Gym Gloves','Sports',399],
            ['Skipping Rope','Sports',199],
            ['Cycling Helmet','Sports',899],
            ['Tennis Ball','Sports',299],
            ['Fitness Band','Sports',1499],
            ['Running Shoes','Sports',2999],

            // Books
            ['Programming Book','Books',699],
            ['Laravel Guide','Books',799],
            ['PHP Master Book','Books',599],
            ['Business Book','Books',499],
            ['Science Book','Books',399],
            ['English Grammar','Books',299],
            ['Computer Network Book','Books',599],
            ['Database Book','Books',699],
            ['AI Learning Book','Books',899],
            ['Marketing Book','Books',499],

            // Accessories
            ['Backpack','Accessories',999],
            ['Laptop Bag','Accessories',1299],
            ['Mobile Cover','Accessories',299],
            ['Phone Stand','Accessories',399],
            ['Car Holder','Accessories',599],
            ['Key Chain','Accessories',99],
            ['Travel Bag','Accessories',1499],
            ['Camera Bag','Accessories',1799],
            ['USB Hub','Accessories',799],
            ['Mouse Pad','Accessories',299],

        ];

        $categoryImages = [

    'Electronics' =>
    'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=500',

    'Fashion' =>
    'https://images.unsplash.com/photo-1445205170230-053b83016050?w=500',

    'Beauty' =>
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500',

    'Home' =>
    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500',

    'Kitchen' =>
    'https://images.unsplash.com/photo-1556911220-bff31c1a1f1b?w=500',

    'Sports' =>
    'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=500',

    'Books' =>
    'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=500',

    'Accessories' =>
    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500',

];
        foreach($products as $product)
        {

           foreach($products as $product)
{

    Product::create([

        'name'=>$product[0],

        'category'=>$product[1],

        'description'=>$product[0].
        " premium quality product from SMART BASKET",

        'image'=>$productImages[$product[0]] 
        ?? $categoryImages[$product[1]]
        ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',

        'price'=>$product[2],

        'rating'=>rand(40,50)/10,

        'stock'=>rand(50,200)

    ]);

}

        }


        // Extra products automatically create
        for($i=1;$i<=40;$i++)
        {

            Product::create([

                'name'=>"Premium Product ".$i,

                'category'=>"Smart Basket Collection",

                'description'=>"Latest premium shopping item",

               'image'=>"https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500",

                'price'=>rand(200,5000),

                'rating'=>rand(40,50)/10,

                'stock'=>rand(20,150)

            ]);

        }

    }
}