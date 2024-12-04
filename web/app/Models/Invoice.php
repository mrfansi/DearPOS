<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'sales_transaction_id',
        'customer_id',
        'branch_id',
        'pos_counter_id',
        'invoice_date',
        'due_date',
        'status', // draft, issued, paid, overdue, cancelled
        'payment_status', // unpaid, partial, paid
        'total_amount',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'additional_charges',
        'notes',
        'is_taxable',
        'tax_rate',
        'created_by',
        'printed_at',
        'sent_at',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:4',
        'subtotal' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'additional_charges' => 'decimal:4',
        'is_taxable' => 'boolean',
        'tax_rate' => 'decimal:4',
        'printed_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the associated sales transaction
     */
    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    /**
     * Get the customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the branch
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get the POS counter
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the creator of the invoice
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get invoice items
     */
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * Get split payments for this invoice
     */
    public function splitPayments(): HasMany
    {
        return $this->hasMany(SplitPayment::class, 'invoice_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if invoice is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if invoice is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || 
               ($this->due_date < now() && !$this->isPaid());
    }

    /**
     * Calculate remaining balance
     */
    public function getRemainingBalanceAttribute()
    {
        $paidAmount = $this->splitPayments()->sum('amount');
        return max(0, $this->total_amount - $paidAmount);
    }

    /**
     * Get payment percentage
     */
    public function getPaymentPercentageAttribute()
    {
        if ($this->total_amount == 0) return 0;
        $paidAmount = $this->splitPayments()->sum('amount');
        return round(($paidAmount / $this->total_amount) * 100, 2);
    }
}
