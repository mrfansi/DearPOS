<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'order_number',
        'marketplace_id',
        'customer_id',
        'branch_id',
        'sales_transaction_id',
        'order_date',
        'status', // pending, processing, shipped, delivered, cancelled, returned
        'payment_status', // unpaid, paid, partial
        'total_amount',
        'subtotal',
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'marketplace_commission',
        'shipping_method',
        'tracking_number',
        'shipping_address_id',
        'billing_address_id',
        'notes',
        'external_order_id',
        'fulfillment_status', // not_fulfilled, partially_fulfilled, fully_fulfilled
        'created_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_amount' => 'decimal:4',
        'subtotal' => 'decimal:4',
        'shipping_amount' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'marketplace_commission' => 'decimal:4',
    ];

    /**
     * Get the marketplace platform
     */
    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id');
    }

    /**
     * Get the customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the branch
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get the associated sales transaction
     */
    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    /**
     * Get the shipping address
     */
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * Get the billing address
     */
    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Get the creator of the order
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get marketplace order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(MarketplaceOrderItem::class, 'marketplace_order_id');
    }

    /**
     * Get marketplace order payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(MarketplaceOrderPayment::class, 'marketplace_order_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if order is fully fulfilled
     */
    public function isFullyFulfilled(): bool
    {
        return $this->fulfillment_status === 'fully_fulfilled';
    }

    /**
     * Calculate total items in the order
     */
    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('quantity');
    }

    /**
     * Get net amount after marketplace commission
     */
    public function getNetAmountAttribute()
    {
        return $this->total_amount - $this->marketplace_commission;
    }
}
