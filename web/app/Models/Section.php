<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'branch_id',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the branch where the section is located
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get all tables in this section
     */
    public function tables(): HasMany
    {
        return $this->hasMany(Table::class, 'section_id');
    }

    /**
     * Get available tables in this section
     */
    public function availableTables(): HasMany
    {
        return $this->tables()
            ->where('status', 'available')
            ->where('is_active', true);
    }

    /**
     * Scope a query to filter by active status
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Count total tables in the section
     */
    public function getTotalTablesAttribute()
    {
        return $this->tables()->count();
    }

    /**
     * Count available tables in the section
     */
    public function getAvailableTablesCountAttribute()
    {
        return $this->availableTables()->count();
    }
}
