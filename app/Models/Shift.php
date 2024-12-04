<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Shift extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'start_time',
        'end_time',
        'working_hours',
        'type',
        'is_active',
        'description'
    ];

    protected $casts = [
        'id' => 'string',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'working_hours' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Generate shift code if not provided
            if (empty($model->code)) {
                $model->code = $model->generateShiftCode();
            }

            // Calculate working hours
            $model->working_hours = $model->calculateWorkingHours();
        });

        static::updating(function ($model) {
            $model->working_hours = $model->calculateWorkingHours();
        });
    }

    public function generateShiftCode()
    {
        $baseCode = strtoupper(substr($this->name, 0, 3));
        $latestShift = self::withTrashed()
            ->where('code', 'like', $baseCode . '%')
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $latestShift ? intval(substr($latestShift->code, -3)) : 0;
        $newNumber = $lastNumber + 1;

        return $baseCode . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function calculateWorkingHours()
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        // Handle overnight shifts
        if ($end < $start) {
            $end->addDay();
        }

        return $start->diffInHours($end, false);
    }

    public function shiftRotations()
    {
        return $this->hasMany(ShiftRotation::class, 'shift_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'shift_id');
    }
}
