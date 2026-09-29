<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = ['label', 'recipient_name', 'phone', 'address_line', 'city', 'state', 'pincode', 'country', 'is_default'];
    protected $casts = ['is_default' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
}
