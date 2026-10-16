<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AICameraHistory extends Model
{
    // The table name in the migration uses the acronym "AI" as one word.
    // Eloquent otherwise pluralizes the class as "a_i_camera_histories".
    protected $table = 'ai_camera_histories';

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
