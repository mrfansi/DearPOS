<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAddress extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'supplier_id',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'address_type' => 'string'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Scopes
    public function scopeDefaultAddress($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeBillingAddress($query)
    {
        return $query->whereIn('address_type', ['billing', 'both']);
    }

    public function scopeShippingAddress($query)
    {
        return $query->whereIn('address_type', ['shipping', 'both']);
    }
};
