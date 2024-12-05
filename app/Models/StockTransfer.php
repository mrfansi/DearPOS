<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransfer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'from_warehouse_id',
        'to_warehouse_id',
        'status',
        'transfer_date',
        'notes'
    ];

    protected $casts = [
        'transfer_date' => 'datetime'
    ];

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function items()
    {
        return $this->hasMany(StockTransferItem::class);
    }

    public function initiateTransfer(int $fromWarehouse, int $toWarehouse): bool
    {
        $this->from_warehouse_id = $fromWarehouse;
        $this->to_warehouse_id = $toWarehouse;
        $this->status = 'initiated';
        $this->transfer_date = now();
        return $this->save();
    }
}
