<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name', // Annual Leave, Sick Leave, Maternity Leave, etc.
        'description',
        'max_days_per_year',
        'is_paid',
        'requires_documentation',
        'is_active',
    ];

    protected $casts = [
        'max_days_per_year' => 'decimal:2',
        'is_paid' => 'boolean',
        'requires_documentation' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the leave requests for this leave type
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class, 'leave_type_id');
    }
}
