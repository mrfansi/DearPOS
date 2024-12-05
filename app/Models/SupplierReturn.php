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
        'status',
        'reason',
        'return_date'
    ];

    protected $casts = [
        'return_date' => 'datetime'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(SupplierReturnItem::class);
    }
}
