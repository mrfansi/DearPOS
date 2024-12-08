<?php

namespace App\Models;

use Database\Factories\SalesTransactionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesTransaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Payment status constants
     */
    public const PAYMENT_STATUS_UNPAID = 'unpaid';

    public const PAYMENT_STATUS_PARTIAL = 'partial';

    public const PAYMENT_STATUS_PAID = 'paid';

    /**
     * Transaction status constants
     */
    public const STATUS_DRAFT = 'draft';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_VOIDED = 'voided';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'transaction_number',
        'customer_id',
        'pos_counter_id',
        'currency_id',
        'transaction_date',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_status',
        'status',
        'notes',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'datetime',
        'subtotal' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'total_amount' => 'decimal:4',
    ];

    /**
     * Get the customer associated with the transaction.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the POS counter where the transaction was processed.
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class);
    }

    /**
     * Get the currency used in the transaction.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the user who created the transaction.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SalesTransactionFactory::new();
    }
}
