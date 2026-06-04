<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingInquiry extends Model
{
    protected $fillable = [
        'listing_id',
        'channel',
        'name',
        'email',
        'phone',
        'message',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(LivestockListing::class, 'listing_id');
    }
}
