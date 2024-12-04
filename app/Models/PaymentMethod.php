<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'type', // cash, card, transfer, etc.
        'is_active',
        'description',
        'requires_reference',
        'supports_installments',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_reference' => 'boolean',
        'supports_installments' => 'boolean',
    ];

    /**
     * Get all payments using this method
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'payment_method_id');
    }

    /**
     * Scope a query to only include active payment methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
