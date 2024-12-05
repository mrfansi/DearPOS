<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceOrderItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'marketplace_order_id',
        'product_id',
        'product_variant_id',
        'external_item_id',
        'name',
        'quantity',
        'unit_price',
        'total_price',
        'discount_amount',
        'tax_amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'total_price' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function marketplaceOrder(): BelongsTo
    {
        return $this->belongsTo(MarketplaceOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function calculateTotalPrice(): void
    {
        $this->total_price = ($this->quantity * $this->unit_price) - $this->discount_amount + $this->tax_amount;
        $this->save();
    }
}
