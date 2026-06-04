<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LivestockCategory extends Model
{
    protected $fillable = [
        'category_group_id',
        'parent_id',
        'name',
        'public_label',
        'slug',
        'description',
        'image',
        'active',
        'display_order',
        'featured',
        'breeds',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'breeds' => 'array',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CategoryGroup::class, 'category_group_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
