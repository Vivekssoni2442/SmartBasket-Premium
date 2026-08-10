<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('products/'.$this->image);
    }

    protected $fillable = [
        'seller_id',
        'name',
        'category',
        'brand',
        'description',
        'image',
        'price',
        'discount_price',
        'rating',
        'stock',
        'size',
        'color',
        'weight',
        'status',
        // AI Camera Shopping Assistant fields (all optional/nullable)
        'body_fit',
        'style_type',
        'color_category',
        'recommended_for',
        'season',
    ];

    /**
     * A product belongs to a seller (User).
     * Uses seller_id column. Returns null for legacy products.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}