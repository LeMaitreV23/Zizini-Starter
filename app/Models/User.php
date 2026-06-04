<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'zizini_users';

    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'email',
        'password',
        'county',
        'business_name',
        'logo_path',
        'seller_type',
        'role',
        'approval_status',
        'verified',
        'posting_status',
        'listing_allowance_total',
        'listing_allowance_used',
        'access_start_date',
        'access_end_date',
        'default_listing_duration',
        'admin_notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'access_start_date' => 'date',
        'access_end_date' => 'date',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(LivestockListing::class, 'seller_id');
    }

    public function accessRequests(): HasMany
    {
        return $this->hasMany(SellerAccessRequest::class, 'seller_id');
    }

    public function remainingAllowance(): Attribute
    {
        return Attribute::get(fn () => max(0, (int) $this->listing_allowance_total - (int) $this->listing_allowance_used));
    }

    public function hasActivePostingAccess(): bool
    {
        return $this->approval_status === 'Approved'
            && $this->posting_status === 'Approved'
            && (! $this->access_end_date || $this->access_end_date->endOfDay()->isFuture())
            && $this->remaining_allowance > 0;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['Admin', 'Super Admin'], true);
    }
}
