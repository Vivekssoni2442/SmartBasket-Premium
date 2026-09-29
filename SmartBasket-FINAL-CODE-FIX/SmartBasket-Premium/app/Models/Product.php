<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = [
        'image_url',
        'video_url',
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

    public function getVideoUrlAttribute(): ?string
    {
        return $this->video ? asset('storage/' . ltrim($this->video, '/')) : null;
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