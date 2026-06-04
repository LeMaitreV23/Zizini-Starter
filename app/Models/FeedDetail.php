<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedDetail extends Model
{
    protected $fillable = ['listing_id', 'feed_type', 'target_animal', 'unit', 'quantity_available', 'brand_name'];
}
