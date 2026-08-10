<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecuritySetting extends Model
{

    protected $fillable = [
        'user_id',
        'email',
        'pin_hash',
        'security_enabled',
        'last_attempt_time',
        'failed_attempt_count',
        'last_security_status'
    ];


    protected $hidden = [
        'pin_hash'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}