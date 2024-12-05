<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'address',
        'parent_location_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_location_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_location_id');
    }

    public function productLocations(): HasMany
    {
        return $this->hasMany(ProductLocation::class);
    }

    public function posCounters(): HasMany
    {
        return $this->hasMany(PosCounter::class);
    }
}
