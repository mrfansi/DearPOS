<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReorderConfig extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'minimum_quantity',
        'maximum_quantity',
        'reorder_point',
        'is_active',
    ];

    protected $casts = [
        'minimum_quantity' => 'decimal:4',
        'maximum_quantity' => 'decimal:4',
        'reorder_point' => 'decimal:4',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function needsReorder(float $currentQuantity): bool
    {
        return $currentQuantity <= $this->reorder_point;
    }

    public function calculateReorderQuantity(float $currentQuantity): float
    {
        if (!$this->needsReorder($currentQuantity)) {
            return 0;
        }

        return min(
            $this->maximum_quantity - $currentQuantity, 
            $this->maximum_quantity
        );
    }
}
