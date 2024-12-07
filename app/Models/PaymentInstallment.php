<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentInstallment extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'payment_id',
        'installment_number',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'due_date' => 'date',
        'paid_date' => 'date'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
};
