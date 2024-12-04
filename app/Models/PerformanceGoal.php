<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceGoal extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'goal_type', // professional, sales, productivity, etc.
        'start_date',
        'target_date',
        'completion_date',
        'status', // not_started, in_progress, completed, partially_completed
        'target_value',
        'actual_value',
        'weight', // importance of the goal
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'target_date' => 'date',
        'completion_date' => 'date',
        'target_value' => 'decimal:2',
        'actual_value' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    /**
     * Get the employee associated with this goal
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Calculate goal achievement percentage
     */
    public function getAchievementPercentageAttribute()
    {
        if ($this->target_value == 0) {
            return 0;
        }
        return min(100, ($this->actual_value / $this->target_value) * 100);
    }
}
