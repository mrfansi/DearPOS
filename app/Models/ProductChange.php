<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductChange extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'field_changed',
        'old_value',
        'new_value',
        'changed_by',
        'change_type',
        'reason',
    ];

    /**
     * Get the product associated with this change
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the user who made the change
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Scope a query to filter by change type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('change_type', $type);
    }

    /**
     * Scope a query to filter by specific field changed
     */
    public function scopeForField($query, $field)
    {
        return $query->where('field_changed', $field);
    }

    /**
     * Check if the change is a significant modification
     */
    public function isSignificantChange()
    {
        return $this->old_value !== $this->new_value;
    }
}
