<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceReview extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'review_period_start',
        'review_period_end',
        'overall_rating',
        'strengths',
        'improvements',
        'goals',
        'status',
    ];

    protected $casts = [
        'review_period_start' => 'date',
        'review_period_end' => 'date',
        'overall_rating' => 'decimal:1',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(Employee::class, 'reviewer_id');
    }
}
