<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceReview extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'review_date',
        'review_period',
        'overall_rating',
        'strengths',
        'areas_for_improvement',
        'goals_for_next_period',
        'reviewer_comments',
        'is_final'
    ];

    protected $casts = [
        'review_date' => 'date',
        'is_final' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(Employee::class, 'reviewer_id');
    }

    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }

    public function scopeByPeriod($query, $period)
    {
        return $query->where('review_period', $period);
    }
}
