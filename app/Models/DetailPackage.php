<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPackage extends Model
{
    use HasFactory;
    protected $table = 'detail_packages';
    protected $guarded = 'id';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function tripPackage(): BelongsTo
    {
        return $this->belongsTo(TripPackage::class, 'trip_package_id', 'id');
    }
}
