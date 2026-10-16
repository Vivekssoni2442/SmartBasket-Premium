<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteDesignRevision extends Model
{
    protected $fillable = [
        'page_key', 'component_key', 'revision', 'settings', 'status',
        'base_revision_id', 'created_by', 'published_by', 'published_at', 'change_note',
    ];

    protected $casts = [
        'settings' => 'array',
        'published_at' => 'datetime',
    ];
}
