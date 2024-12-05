<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRecipe extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'instructions',
        'yield_quantity'
    ];

    protected $casts = [
        'yield_quantity' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(RecipeItem::class, 'recipe_id');
    }

    public function calculateCost(): float
    {
        return $this->items->sum(function ($item) {
            $price = $item->product->prices()->where('is_active', true)->first()?->base_price ?? 0;
            return $price * $item->quantity;
        });
    }

    public function updateYield(float $quantity): bool
    {
        $this->yield_quantity = $quantity;
        return $this->save();
    }
}
