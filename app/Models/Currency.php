<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',   // 3-letter currency code (e.g., USD, IDR)
        'name',   // Full name of the currency
        'exchange_rate', // Current exchange rate
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:4',
    ];

    /**
     * Get products priced in this currency
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'base_currency_id');
    }

    /**
     * Get sales transactions in this currency
     */
    public function salesTransactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class, 'currency_id');
    }
}
