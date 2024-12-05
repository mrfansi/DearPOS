<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'tax_number',
        'credit_limit',
        'status',
        'notes',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(CustomerContact::class);
    }
}
