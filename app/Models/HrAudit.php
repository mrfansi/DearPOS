<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrAudit extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'reason',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByModelType($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }
}
