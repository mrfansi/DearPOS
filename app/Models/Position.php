<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Position extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'code',
        'department_id',
        'job_description',
        'minimum_salary',
        'maximum_salary',
        'is_management_position',
        'is_active'
    ];

    protected $casts = [
        'id' => 'string',
        'minimum_salary' => 'decimal:4',
        'maximum_salary' => 'decimal:4',
        'is_management_position' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Generate position code if not provided
            if (empty($model->code)) {
                $model->code = $model->generatePositionCode();
            }
        });
    }

    public function generatePositionCode()
    {
        $baseCode = strtoupper(substr($this->title, 0, 3));
        $latestPosition = self::withTrashed()
            ->where('code', 'like', $baseCode . '%')
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $latestPosition ? intval(substr($latestPosition->code, -3)) : 0;
        $newNumber = $lastNumber + 1;

        return $baseCode . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id');
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'position_id');
    }
}
