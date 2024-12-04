<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ExpiryAlert extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'lot_id',
        'days_before_expiry',
        'is_active',
        'last_triggered_at',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_triggered_at' => 'datetime',
    ];

    /**
     * Get the product associated with this expiry alert
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this expiry alert (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the inventory lot associated with this expiry alert (optional)
     */
    public function lot(): BelongsTo
    {
        return $this->belongsTo(InventoryLot::class, 'lot_id');
    }

    /**
     * Get the user who created this expiry alert
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if the alert is triggered for a specific lot
     */
    public function isTriggered(?InventoryLot $lot = null)
    {
        $targetLot = $lot ?? $this->lot;

        if (!$targetLot || !$targetLot->expiry_date) {
            return false;
        }

        $daysUntilExpiry = now()->diffInDays($targetLot->expiry_date);
        return $daysUntilExpiry <= $this->days_before_expiry;
    }

    /**
     * Trigger the alert and update last triggered time
     */
    public function triggerAlert()
    {
        $this->last_triggered_at = now();
        $this->save();
    }

    /**
     * Scope a query to find active alerts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to find alerts for products nearing expiry
     */
    public function scopeNearingExpiry($query)
    {
        return $query->whereHas('lot', function ($q) {
            $q->where('expiry_date', '<=', now()->addDays($this->days_before_expiry));
        });
    }
}
