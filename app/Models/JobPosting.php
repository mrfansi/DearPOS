<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'department_id',
        'position_id',
        'description',
        'requirements',
        'salary_range_min',
        'salary_range_max',
        'employment_type', // full-time, part-time, contract, etc.
        'location',
        'is_active',
        'posting_date',
        'closing_date',
    ];

    protected $casts = [
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
        'posting_date' => 'date',
        'closing_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the department for this job posting
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the position for this job posting
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * Get the candidates for this job posting
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'job_posting_id');
    }
}
