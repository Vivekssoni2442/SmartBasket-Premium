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
     * A product belongs to the seller profile identified by seller_id.
     * Returns null for legacy products without a seller.
     */
    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
}
