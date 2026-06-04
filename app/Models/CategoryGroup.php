<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryGroup extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'active', 'display_order'];

    protected $casts = ['active' => 'boolean'];

    public function categories(): HasMany
    {
        return $this->hasMany(LivestockCategory::class);
    }
}
