<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip_AcomodationModel extends Model
{
    use HasFactory;
    protected $table = "trip_packages";
    protected $guarded = ['id'];

    public function trip_package() : BelongsTo
    {
        return $this->belongsTo(TripPackage::class, 'trip_package_id', 'id');
    }
}
