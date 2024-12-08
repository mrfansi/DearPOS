<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'sales_transaction_id',
        'payment_method_id',
        'amount',
        'currency_id',
        'exchange_rate',
        'status',
        'payment_date',
        'reference_number',
        'notes',
        'is_partial',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'exchange_rate' => 'decimal:4',
        'payment_date' => 'datetime',
        'is_partial' => 'boolean',
    ];

    public function salesTransaction()
    {
        return $this->belongsTo(SalesTransaction::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function installments()
    {
        return $this->hasMany(PaymentInstallment::class);
    }
}
