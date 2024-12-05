<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxExemption extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'tax_number',
        'document_path',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function isValid(): bool
    {
        $now = now();
        return $now->greaterThanOrEqualTo($this->valid_from) && 
               $now->lessThanOrEqualTo($this->valid_until);
    }

    public function scopeActive($query)
    {
        $now = now();
        return $query->where('valid_from', '<=', $now)
                     ->where('valid_until', '>=', $now);
    }

    public function scopeExpired($query)
    {
        $now = now();
        return $query->where('valid_until', '<', $now);
    }
}
