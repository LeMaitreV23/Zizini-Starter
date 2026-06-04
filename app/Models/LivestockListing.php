<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LivestockListing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'seller_id',
        'category_group_id',
        'category_id',
        'county_id',
        'listing_type',
        'slug',
        'title',
        'category',
        'breed',
        'price',
        'price_type',
        'price_negotiable',
        'county',
        'location',
        'age',
        'sex',
        'health_status',
        'vaccination_status',
        'milk_production',
        'weight',
        'description',
        'owner_phone',
        'owner_whatsapp',
        'preferred_contact',
        'featured',
        'verified',
        'verified_badge',
        'status',
        'views',
        'contact_clicks',
        'email_clicks',
        'whatsapp_clicks',
        'call_clicks',
        'expires_at',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'images',
        'published_at',
        'verified_at',
        'taken_down_at',
        'admin_notes',
    ];

    protected $casts = [
        'price_negotiable' => 'boolean',
        'featured' => 'boolean',
        'verified' => 'boolean',
        'verified_badge' => 'boolean',
        'expires_at' => 'date',
        'images' => 'array',
        'published_at' => 'datetime',
        'approved_at' => 'datetime',
        'verified_at' => 'datetime',
        'taken_down_at' => 'datetime',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function categoryModel(): BelongsTo
    {
        return $this->belongsTo(LivestockCategory::class, 'category_id');
    }

    public function categoryGroup(): BelongsTo
    {
        return $this->belongsTo(CategoryGroup::class, 'category_group_id');
    }

    public function countyModel(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function animalDetail(): HasMany
    {
        return $this->hasMany(AnimalDetail::class, 'listing_id');
    }

    public function feedDetail(): HasMany
    {
        return $this->hasMany(FeedDetail::class, 'listing_id');
    }

    public function serviceDetail(): HasMany
    {
        return $this->hasMany(ServiceDetail::class, 'listing_id');
    }

    public function listingImages(): HasMany
    {
        return $this->hasMany(ListingImage::class, 'listing_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ListingReport::class, 'listing_id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(ListingInquiry::class, 'listing_id');
    }
}
