<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteRecord extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'reason'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function recordWaste(int $product, int $warehouse, int $quantity): bool
    {
        $this->product_id = $product;
        $this->warehouse_id = $warehouse;
        $this->quantity = $quantity;
        return $this->save();
    }
}
