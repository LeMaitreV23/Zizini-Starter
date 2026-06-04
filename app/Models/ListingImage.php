<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    protected $fillable = ['listing_id', 'path', 'alt_text', 'is_primary', 'display_order'];

    protected $casts = ['is_primary' => 'boolean'];
}
