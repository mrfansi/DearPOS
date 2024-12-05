<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'recipe_id',
        'product_id',
        'quantity',
        'unit'
    ];

    protected $casts = [
        'quantity' => 'decimal:2'
    ];

    public function recipe()
    {
        return $this->belongsTo(ProductRecipe::class, 'recipe_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
