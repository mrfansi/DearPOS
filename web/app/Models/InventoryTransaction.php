<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'transaction_type',
        'reference_id',
        'reference_type',
        'location_id',
        'transaction_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    /**
     * Get the location associated with the transaction
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the creator of the transaction
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the transaction items
     */
    public function items(): HasMany
    {
        return $this->hasMany(InventoryTransactionItem::class, 'transaction_id');
    }

    /**
     * Scope a query to filter by transaction type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }

    /**
     * Determine if the transaction affects stock positively
     */
    public function isStockIncrease()
    {
        $increaseTypes = ['purchase', 'return', 'adjustment_add', 'transfer_in'];
        return in_array($this->transaction_type, $increaseTypes);
    }

    /**
     * Determine if the transaction affects stock negatively
     */
    public function isStockDecrease()
    {
        $decreaseTypes = ['sale', 'waste', 'adjustment_remove', 'transfer_out'];
        return in_array($this->transaction_type, $decreaseTypes);
    }
}
