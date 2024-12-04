<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitsOfMeasure extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'units_of_measures';

    protected $fillable = [
        'code',
        'name',
        'category', // weight, length, volume, count, etc.
    ];

    /**
     * Get products using this unit
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'base_unit_id');
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
