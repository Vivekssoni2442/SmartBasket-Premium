<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceWatch extends Model
{
    protected $fillable = ['user_id', 'product_id', 'tracked_price', 'previous_price'];
    protected $casts = ['tracked_price' => 'decimal:2', 'previous_price' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
