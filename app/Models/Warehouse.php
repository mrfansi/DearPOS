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
        'code',
        'location_id',
        'manager_id',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function storageLocations()
    {
        return $this->hasMany(StorageLocation::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class);
    }

    public function sourceTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'source_warehouse_id');
    }

    public function destinationTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'destination_warehouse_id');
    }
}
