<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'quantity',
        'unit_id',
        'is_optional',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'is_optional' => 'boolean',
    ];

    /**
     * Get the recipe associated with this item
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(ProductRecipe::class, 'recipe_id');
    }

    /**
     * Get the ingredient product
     */
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ingredient_id');
    }

    /**
     * Get the unit of measure for the ingredient quantity
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    /**
     * Calculate the total cost of this recipe item
     */
    public function getTotalCostAttribute()
    {
        return $this->quantity * $this->ingredient->current_cost;
    }

    /**
     * Scope a query to find optional recipe items
     */
    public function scopeOptional($query)
    {
        return $query->where('is_optional', true);
    }

    /**
     * Scope a query to find mandatory recipe items
     */
    public function scopeMandatory($query)
    {
        return $query->where('is_optional', false);
    }
}
