<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tag_id',
        'country_id',
        'city_id',
        'province_id',
        'destination_name',
        'image',
        'price',
        'description',
        'private_price'
    ];

    protected $guarded = ['id'];

    public function getuser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gettag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }

    public function getcountry()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function getcity()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function getprovince()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/destinations/' . $value),
        );
    }
}
