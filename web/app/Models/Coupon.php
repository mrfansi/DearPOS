<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type', // percentage, fixed_amount
        'value',
        'minimum_purchase_amount',
        'maximum_coupon_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'per_customer_limit',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'minimum_purchase_amount' => 'decimal:4',
        'maximum_coupon_amount' => 'decimal:4',
        'start_date' => 'date',
        'end_date' => 'date',
        'usage_limit' => 'integer',
        'per_customer_limit' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Products this coupon applies to
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'coupon_products', 'coupon_id', 'product_id');
    }

    /**
     * Product categories this coupon applies to
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'coupon_categories', 'coupon_id', 'category_id');
    }

    /**
     * Sales transactions using this coupon
     */
    public function salesTransactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class, 'coupon_id');
    }

    /**
     * Scope a query to only include active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    /**
     * Check if coupon is currently valid
     */
    public function isValid(): bool
    {
        return $this->is_active && 
               now()->between($this->start_date, $this->end_date) &&
               $this->getRemainingUsageAttribute() > 0;
    }

    /**
     * Calculate coupon discount amount
     */
    public function calculateCouponAmount($totalAmount)
    {
        switch ($this->type) {
            case 'percentage':
                $couponAmount = $totalAmount * ($this->value / 100);
                break;
            case 'fixed_amount':
                $couponAmount = $this->value;
                break;
            default:
                $couponAmount = 0;
        }

        // Respect maximum coupon amount if set
        if ($this->maximum_coupon_amount > 0) {
            $couponAmount = min($couponAmount, $this->maximum_coupon_amount);
        }

        return $couponAmount;
    }

    /**
     * Get remaining usage count
     */
    public function getRemainingUsageAttribute()
    {
        $usedCount = $this->salesTransactions()->count();
        return max(0, $this->usage_limit - $usedCount);
    }
}
