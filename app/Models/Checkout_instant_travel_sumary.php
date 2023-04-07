<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout_instant_travel_sumary extends Model
{
    use HasFactory;
    protected $table = 'checkout_instant_travel_sumaries';
    protected $guarded = ['id'];

     public function palace(): BelongsTo
    {
        return $this->belongsTo(Palace::class, 'palace_id', 'id');
    }
}
