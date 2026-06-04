<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $fillable = ['listing_id', 'service_type', 'provider_type', 'service_area', 'availability', 'pricing_model', 'quote_note'];
}
