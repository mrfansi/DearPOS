<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierReturn extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'return_number',
        'return_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'return_date' => 'date',
        'status' => 'string',
        'total_amount' => 'decimal:4',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(SupplierReturnItem::class);
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
