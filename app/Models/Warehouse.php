<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function stockTransfersFrom()
    {
        return $this->hasMany(StockTransfer::class, 'from_warehouse_id');
    }

    public function stockTransfersTo()
    {
        return $this->hasMany(StockTransfer::class, 'to_warehouse_id');
    }

    public function wasteRecords()
    {
        return $this->hasMany(WasteRecord::class);
    }

    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class);
    }
}
