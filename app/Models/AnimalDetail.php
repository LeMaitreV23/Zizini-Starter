<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalDetail extends Model
{
    protected $fillable = ['listing_id', 'animal_purpose', 'species', 'breed', 'sex', 'age', 'weight', 'milk_production', 'vaccination_status', 'health_status', 'pregnancy_status', 'quantity'];
}
