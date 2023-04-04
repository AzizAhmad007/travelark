<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Palace extends Model
{
    use HasFactory;
    protected $table = "palaces"; 
    protected $guarded = ['id'];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
     public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
     public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
     public function city(): BelongsTo
    {
        return $this->belongsTo(CitiModel::class, 'city_id', 'id');
    }
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
    
}
