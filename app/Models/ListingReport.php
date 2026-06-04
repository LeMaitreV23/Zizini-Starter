<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingReport extends Model
{
    protected $fillable = [
        'listing_id',
        'reason',
        'reported_by',
        'reporter_contact',
        'status',
        'admin_notes',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(LivestockListing::class, 'listing_id');
    }
}
