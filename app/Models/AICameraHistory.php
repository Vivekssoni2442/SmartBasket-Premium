<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AICameraHistory extends Model
{
    protected $fillable = [
        'user_id',
        'query',
        'analysis',
        'image_path',
        'result_image',
    ];

    protected $casts = [
        'analysis' => 'array',
    ];
}