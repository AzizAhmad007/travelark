<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout_package_travel_sumary extends Model
{
    use HasFactory;
    protected $table = 'checkout_package_travel_sumaries';
    protected $guarded = ['id'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function trip_package(): BelongsTo
    {
        return $this->belongsTo(TripPackage::class, 'trip_package_id', 'id');
    }
}
