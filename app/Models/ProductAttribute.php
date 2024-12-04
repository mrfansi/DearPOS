<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'data_type',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Get the attribute values for this attribute
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }

    /**
     * Validate attribute value based on data type
     */
    public function validateValue($value)
    {
        switch ($this->data_type) {
            case 'string':
                return is_string($value);
            case 'integer':
                return is_int($value);
            case 'decimal':
                return is_numeric($value);
            case 'boolean':
                return is_bool($value);
            case 'date':
                return strtotime($value) !== false;
            default:
                return true;
        }
    }
}
