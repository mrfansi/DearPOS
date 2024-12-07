<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'default_days',
        'is_accumulative',
        'is_paid',
        'requires_approval',
        'is_active'
    ];

    protected $casts = [
        'default_days' => 'integer',
        'is_accumulative' => 'boolean',
        'is_paid' => 'boolean',
        'requires_approval' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
