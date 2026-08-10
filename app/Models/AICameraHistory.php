<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| AI Camera Assistant History
|--------------------------------------------------------------------------
| Stores a small record of each analysis for a logged-in user.
| Only the normalized analysis payload (JSON) and a temporary source
| reference are retained; raw image bytes are never persisted.
*/

class AICameraHistory extends Model
{
    // Explicitly set the table name. Without this, Laravel's snake_case on
    // "AICameraHistory" would produce "a_i_camera_histories", which does not
    // match the migration-created "ai_camera_histories" table.
    protected $table = 'ai_camera_histories';

    protected $fillable = [
        'user_id',
        'image_path',
        'result_image',
        'query',
        'analysis',
    ];

    protected $casts = [
        'analysis' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
