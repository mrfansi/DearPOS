<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryValuation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'quantity',
        'unit_cost',
        'total_value',
        'valuation_date',
        'method',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'total_value' => 'decimal:4',
        'valuation_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeFifo($query)
    {
        return $query->where('method', 'FIFO');
    }

    public function scopeLifo($query)
    {
        return $query->where('method', 'LIFO');
    }

    public function scopeAverage($query)
    {
        return $query->where('method', 'Average');
    }

    public function calculateTotalValue(): float
    {
        return $this->quantity * $this->unit_cost;
    }
}
