<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $table = 'about_contents';

    protected $fillable = [
        'title',
        'introduction',
        'mission',
        'vision',
        'services',
        'additional_information',
    ];
}
