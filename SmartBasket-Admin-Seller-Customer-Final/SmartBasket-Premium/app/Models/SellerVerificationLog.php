<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SellerVerificationLog extends Model { protected $fillable = ['seller_profile_id','actor_id','event','from_status','to_status','metadata']; protected function casts(): array { return ['metadata' => 'array']; } public function seller() { return $this->belongsTo(SellerProfile::class, 'seller_profile_id'); } }
