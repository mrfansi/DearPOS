<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'parent_category_id',
        'level',
        'path',
        'is_active'
    ];

    protected $casts = [
        'level' => 'integer',
        'is_active' => 'boolean'
    ];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
