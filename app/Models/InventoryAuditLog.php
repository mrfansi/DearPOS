<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InventoryAuditLog extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'audit_date',
        'system_quantity',
        'physical_quantity',
        'difference',
        'status',
        'notes',
        'audited_by'
    ];

    protected $casts = [
        'id' => 'string',
        'audit_date' => 'date',
        'system_quantity' => 'decimal:4',
        'physical_quantity' => 'decimal:4',
        'difference' => 'decimal:4'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Calculate difference
            $model->difference = $model->physical_quantity - $model->system_quantity;

            // Update status based on difference
            $model->status = $model->difference == 0 ? 'reconciled' :
                ($model->difference != 0 ? 'discrepancy' : 'pending');
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'audited_by');
    }
}
