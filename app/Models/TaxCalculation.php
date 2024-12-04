<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxCalculation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'tax_year',
        'gross_income',
        'taxable_income',
        'tax_deductions',
        'tax_exemptions',
        'calculated_tax',
        'tax_paid',
        'tax_balance',
        'tax_status', // paid, pending, overpaid, underpaid
        'calculation_date',
    ];

    protected $casts = [
        'tax_year' => 'integer',
        'gross_income' => 'decimal:2',
        'taxable_income' => 'decimal:2',
        'tax_deductions' => 'decimal:2',
        'tax_exemptions' => 'decimal:2',
        'calculated_tax' => 'decimal:2',
        'tax_paid' => 'decimal:2',
        'tax_balance' => 'decimal:2',
        'calculation_date' => 'date',
    ];

    /**
     * Get the employee associated with this tax calculation
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
