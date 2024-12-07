<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierContact extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'position',
        'email',
        'phone',
        'mobile',
        'is_primary',
        'notes'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Scopes
    public function scopePrimaryContact($query)
    {
        return $query->where('is_primary', true);
    }
};
