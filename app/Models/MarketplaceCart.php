<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketplaceCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'items',
        'paid_at',
    ];

    protected $dates = [
        'paid_at'
    ];

    protected $casts = [
        'items' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
