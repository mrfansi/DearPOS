<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockAlert extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'alert_type',
        'message',
        'is_resolved',
        'resolved_at'
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function generateAlert(int $product, string $type): bool
    {
        $this->product_id = $product;
        $this->alert_type = $type;
        return $this->save();
    }

    public function resolve(): bool
    {
        $this->is_resolved = true;
        $this->resolved_at = now();
        return $this->save();
    }
}
