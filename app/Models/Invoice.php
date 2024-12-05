<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'status',
        'payment_status',
        'total_amount',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'additional_charges',
        'is_taxable',
        'tax_rate',
        'notes',
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
        'tax_rate' => 'decimal:2',
        'printed_at' => 'datetime',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                     ->orWhere('due_date', '<', now());
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    public function scopePartiallyPaid($query)
    {
        return $query->where('payment_status', 'partial');
    }

    public function calculateTotalWithTax(): float
    {
        $total = $this->subtotal;
        
        if ($this->is_taxable && $this->tax_rate) {
            $total += ($this->subtotal * ($this->tax_rate / 100));
        }

        if ($this->additional_charges) {
            $total += $this->additional_charges;
        }

        if ($this->discount_amount) {
            $total -= $this->discount_amount;
        }

        return round($total, 4);
    }

    public function markAsPrinted(): void
    {
        $this->printed_at = now();
        $this->save();
    }

    public function markAsSent(): void
    {
        $this->sent_at = now();
        $this->save();
    }
}
