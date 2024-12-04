<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'contact_person',
        'contact_email',
        'contact_phone',
        'currency_id',
        'tax_number',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the preferred currency for this supplier
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get the purchase orders from this supplier
     */
    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id');
    }

    /**
     * Get the products supplied by this supplier
     */
    public function suppliedProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'primary_supplier_id');
    }

    /**
     * Scope a query to find active suppliers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate total purchase amount from this supplier
     */
    public function getTotalPurchaseAmountAttribute()
    {
        return $this->purchaseOrders()
                    ->where('status', 'completed')
                    ->sum('total_amount');
    }

    /**
     * Get the number of completed purchase orders
     */
    public function getCompletedPurchaseOrdersCountAttribute()
    {
        return $this->purchaseOrders()
                    ->where('status', 'completed')
                    ->count();
    }

    /**
     * Validate supplier contact information
     */
    public function validateContactInfo()
    {
        return !empty($this->contact_email) || 
               !empty($this->contact_phone);
    }
}
