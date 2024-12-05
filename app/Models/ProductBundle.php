<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBundle extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(BundleItem::class, 'bundle_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_items')
            ->withPivot(['quantity', 'price_adjustment'])
            ->withTimestamps();
    }

    public function calculatePrice(): float
    {
        $total = $this->items->sum(function ($item) {
            $price = $item->product->prices()->where('is_active', true)->first()?->base_price ?? 0;
            return ($price + $item->price_adjustment) * $item->quantity;
        });

        if ($this->discount_percentage > 0) {
            $total -= ($total * $this->discount_percentage / 100);
        }

        return round($total, 2);
    }

    public function isValid(): bool
    {
        $now = now();

        if (!$this->is_active) {
            return false;
        }

        if ($this->start_date && $now < $this->start_date) {
            return false;
        }

        if ($this->end_date && $now > $this->end_date) {
            return false;
        }

        return true;
    }
}
