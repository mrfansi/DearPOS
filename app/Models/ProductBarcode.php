<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBarcode extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'barcode_type',
        'barcode_value',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function generate(): string
    {
        // TODO: Implement barcode generation logic
        return '';
    }

    public function validate(): bool
    {
        // TODO: Implement barcode validation logic
        return true;
    }
}
