<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'destination_id'
    ];

    protected $guarded = ['id'];

    public function getdestination()
    {
        return $this->hasMany(Destination::class, 'destination_id', 'id');
    }
}
