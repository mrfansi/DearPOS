<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMovement extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'movement_type',
        'quantity',
        'reference_type',
        'reference_id',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function validateStock(): bool
    {
        if ($this->movement_type === 'out') {
            $currentStock = $this->product->variants->sum('stock_level');
            return $currentStock >= abs($this->quantity);
        }
        return true;
    }

    public function revertMovement(): bool
    {
        // TODO: Implement movement reversion logic
        return true;
    }
}
