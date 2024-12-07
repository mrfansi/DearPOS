<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'group_id',
        'code',
        'name',
        'email',
        'phone',
        'mobile',
        'tax_number',
        'credit_limit',
        'current_balance',
        'notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credit_limit' => 'decimal:4',
        'current_balance' => 'decimal:4',
        'status' => 'string',
    ];

    /**
     * Get the group that owns the customer.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'group_id');
    }

    /**
     * Get the addresses for the customer.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    /**
     * Get the contacts for the customer.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(CustomerContact::class);
    }

    /**
     * Get the credit history for the customer.
     */
    public function creditHistory(): HasMany
    {
        return $this->hasMany(CustomerCreditHistory::class);
    }
}
