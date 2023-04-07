<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout_instant_travel_sumary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instant_travel_id',
        'total_price',
        'checkout_id'
    ];

    protected $guarded = ['id'];

    public function getuser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getinstant_travel()
    {
        return $this->belongsTo(Instant_travel::class, 'instant_travel_id', 'id');
    }

    public function getcheckout()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id', 'id');
    }
}
