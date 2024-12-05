<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'recipe_id',
        'ingredient_product_id',
        'ingredient_variant_id',
        'quantity',
        'unit_id',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(ProductRecipe::class, 'recipe_id');
    }

    public function ingredientProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ingredient_product_id');
    }

    public function ingredientVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'ingredient_variant_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
    }
}
