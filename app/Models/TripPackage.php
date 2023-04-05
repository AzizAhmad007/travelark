<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripPackage extends Model
{
    use HasFactory;
    protected $table = "trip_packages";
    protected $guarded = ['id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }

    public function guide() : BelongsTo
    {
        return $this->belongsTo(Guide::class, 'guide_id', 'id');
    }
}
