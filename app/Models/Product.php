<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = [
        'image_url',
    ];

    /*
    |--------------------------------------------------------------------------
    | IMAGE URL
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute()
    {
        return asset(
            'products/' . $this->image
        );
    }

    /** The only price customers may be charged: a valid lower sale price or list price. */
    public function getEffectivePriceAttribute(): float
    {
        $price = (float) $this->price;
        $discount = $this->discount_price;

        return $discount !== null && (float) $discount >= 0 && (float) $discount < $price
            ? (float) $discount
            : $price;
    }

    /** Compatibility helpers used by the customer discovery features. */
    public function sellingPrice(): float
    {
        return $this->effective_price;
    }

    public function scopeCustomerVisible($query)
    {
        return $query->where(function ($products) {
            $products->whereNull('status')->orWhere('status', 'active');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'seller_id',

        'name',

        'category',

        'brand',

        'description',

        'image',

        'video',

        'price',

        'discount_price',

        'rating',

        'stock',

        'size',

        'color',

        'weight',

        'status',

        /*
        |--------------------------------------------------------------------------
        | AI CAMERA SHOPPING ASSISTANT
        |--------------------------------------------------------------------------
        */

        'body_fit',

        'style_type',

        'color_category',

        'recommended_for',

        'season',
    ];

    /*
    |--------------------------------------------------------------------------
    | SELLER
    |--------------------------------------------------------------------------
    */

    public function seller()
    {
        return $this->belongsTo(
            SellerProfile::class,
            'seller_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT IMAGES
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(
            ProductImage::class
        )
        ->orderBy('sort_order');
    }
}
