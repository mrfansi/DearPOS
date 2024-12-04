<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRecipe extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'yield_quantity',
        'yield_unit_id',
        'preparation_time',
        'cooking_time',
    ];

    protected $casts = [
        'yield_quantity' => 'decimal:4',
        'preparation_time' => 'decimal:2',
        'cooking_time' => 'decimal:2',
    ];

    /**
     * Get the product associated with this recipe
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the yield unit of measure
     */
    public function yieldUnit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'yield_unit_id');
    }

    /**
     * Get the recipe items (ingredients)
     */
    public function items(): HasMany
    {
        return $this->hasMany(RecipeItem::class, 'recipe_id');
    }

    /**
     * Calculate total preparation and cooking time
     */
    public function getTotalTimeAttribute()
    {
        return ($this->preparation_time ?? 0) + ($this->cooking_time ?? 0);
    }

    /**
     * Get the total cost of the recipe based on ingredient costs
     */
    public function getTotalCostAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->ingredient->current_cost;
        });
    }
}
