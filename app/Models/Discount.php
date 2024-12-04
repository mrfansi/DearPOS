<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type', // percentage, fixed_amount, buy_x_get_y
        'value',
        'minimum_purchase_amount',
        'maximum_discount_amount',
        'start_date',
        'end_date',
        'is_active',
        'applies_to', // all_products, specific_products, specific_categories
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'minimum_purchase_amount' => 'decimal:4',
        'maximum_discount_amount' => 'decimal:4',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Products this discount applies to
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_products', 'discount_id', 'product_id');
    }

    /**
     * Product categories this discount applies to
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'discount_categories', 'discount_id', 'category_id');
    }

    /**
     * Sales transactions using this discount
     */
    public function salesTransactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class, 'discount_id');
    }

    /**
     * Scope a query to only include active discounts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    /**
     * Check if discount is currently valid
     */
    public function isValid(): bool
    {
        return $this->is_active && 
               now()->between($this->start_date, $this->end_date);
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscountAmount($totalAmount)
    {
        switch ($this->type) {
            case 'percentage':
                $discountAmount = $totalAmount * ($this->value / 100);
                break;
            case 'fixed_amount':
                $discountAmount = $this->value;
                break;
            default:
                $discountAmount = 0;
        }

        // Respect maximum discount amount if set
        if ($this->maximum_discount_amount > 0) {
            $discountAmount = min($discountAmount, $this->maximum_discount_amount);
        }

        return $discountAmount;
    }
}
