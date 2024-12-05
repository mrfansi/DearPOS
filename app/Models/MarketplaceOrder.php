<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'order_number',
        'marketplace',
        'external_order_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'total_amount',
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'grand_total',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:4',
        'shipping_amount' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'grand_total' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MarketplaceOrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function calculateGrandTotal(): void
    {
        $this->grand_total = $this->total_amount + 
                              $this->shipping_amount + 
                              $this->tax_amount - 
                              $this->discount_amount;
        $this->save();
    }
}
