<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketplace extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'platform_code', // shopee, lazada, tokopedia, etc.
        'commission_rate',
        'api_key',
        'api_secret',
        'webhook_url',
        'is_active',
        'sync_frequency', // daily, hourly, realtime
        'integration_type', // direct, middleware
        'support_email',
        'support_phone',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'commission_rate' => 'decimal:4',
    ];

    /**
     * Get marketplace orders
     */
    public function marketplaceOrders(): HasMany
    {
        return $this->hasMany(MarketplaceOrder::class, 'marketplace_id');
    }

    /**
     * Scope a query to filter by active status
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get total orders for this marketplace
     */
    public function getTotalOrdersAttribute()
    {
        return $this->marketplaceOrders()->count();
    }

    /**
     * Get total revenue from this marketplace
     */
    public function getTotalRevenueAttribute()
    {
        return $this->marketplaceOrders()->sum('total_amount');
    }
}
