<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'last_updated'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'last_updated' => 'datetime'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function updateStock(int $quantity): bool
    {
        $this->quantity = $quantity;
        $this->last_updated = now();
        return $this->save();
    }
}
