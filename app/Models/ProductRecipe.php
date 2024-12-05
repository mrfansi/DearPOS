<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRecipe extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'output_quantity',
        'output_unit_id',
        'instructions',
    ];

    protected $casts = [
        'output_quantity' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function outputUnit(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class, 'output_unit_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RecipeItem::class, 'recipe_id');
    }
}
