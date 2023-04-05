<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstantTravelModel extends Model
{
    //use HasFactory;
    use HasFactory;
    protected $table = "instant_travels";
    protected $guarded = ['id'];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function palace(): BelongsTo
    {
        return $this->belongsTo(Palace::class, 'palace_id', 'id');
    }

}
