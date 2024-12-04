<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class StockAlert extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'location_id',
        'alert_type',
        'threshold_quantity',
        'current_quantity',
        'is_active',
        'last_triggered_at',
        'created_by',
    ];

    protected $casts = [
        'threshold_quantity' => 'decimal:4',
        'current_quantity' => 'decimal:4',
        'is_active' => 'boolean',
        'last_triggered_at' => 'datetime',
    ];

    /**
     * Get the product associated with this stock alert
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this stock alert (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the location associated with this stock alert
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the user who created this stock alert
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if the alert is triggered
     */
    public function isTriggered()
    {
        return match($this->alert_type) {
            'low_stock' => $this->current_quantity <= $this->threshold_quantity,
            'high_stock' => $this->current_quantity >= $this->threshold_quantity,
            default => false,
        };
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
     * Scope a query to find alerts by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('alert_type', $type);
    }
}
