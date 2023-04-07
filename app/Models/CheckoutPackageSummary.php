<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckoutPackageSummary extends Model
{
    use HasFactory;
    protected $table = 'checkout_package_summaries';
    protected $guarded = 'id';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function detailPackage(): BelongsTo
    {
        return $this->belongsTo(DetailPackage::class, 'detail_package_id', 'id');
    }
}
