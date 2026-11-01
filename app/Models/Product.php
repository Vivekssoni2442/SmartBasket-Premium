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
        $now = now();
        $saleStarts = $this->sale_starts_at;
        $saleEnds = $this->sale_ends_at;
        $saleIsActive = $this->sale_price !== null
            && (float) $this->sale_price >= 0
            && (float) $this->sale_price < $price
            && $saleStarts && $saleEnds
            && $now->greaterThanOrEqualTo($saleStarts)
            && $now->lessThan($saleEnds);

        if ($saleIsActive) {
            return (float) $this->sale_price;
        }

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
        return $query
            ->where(function ($products) {
                $products->whereNull('status')->orWhere('status', 'active');
            })
            ->where(function ($products) {
                $products->whereNull('seller_id')
                    ->orWhereHas('seller', function ($seller) {
                        $seller->whereNull('blocked_at');
                    });
            })
            ->where(function ($products) {
                $products->where('stock', '>', 0);
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

        'video_poster',

        'price',

        'discount_price',

        'sale_title',
        'sale_offer',
        'sale_price',
        'sale_starts_at',
        'sale_ends_at',

        'coupon_title',
        'coupon_code',
        'coupon_description',
        'coupon_discount_type',
        'coupon_discount_value',
        'coupon_starts_at',
        'coupon_ends_at',
        'coupon_design',

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

    protected function casts(): array
    {
        return [
            'sale_price' => 'decimal:2',
            'sale_starts_at' => 'datetime',
            'sale_ends_at' => 'datetime',
            'coupon_discount_value' => 'decimal:2',
            'coupon_starts_at' => 'datetime',
            'coupon_ends_at' => 'datetime',
        ];
    }

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

    public function videos()
    {
        return $this->hasMany(ProductVideo::class)->orderBy('sort_order');
    }
}
