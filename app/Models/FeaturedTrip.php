<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedTrip extends Model
{
    use HasFactory;
    protected $table = "Featured_trips";
    protected $guarded = ['id'];

    public function trip_package() : BelongsTo
    {
        return $this->belongsTo(TripPackage::class, 'trip_package_id', 'id');
    }
}
