<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'parent_department_id',
        'head_of_department_id',
        'description',
        'is_active'
    ];

    protected $casts = [
        'id' => 'string',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Generate department code if not provided
            if (empty($model->code)) {
                $model->code = $model->generateDepartmentCode();
            }
        });
    }

    public function generateDepartmentCode()
    {
        $baseCode = strtoupper(substr($this->name, 0, 3));
        $latestDepartment = self::withTrashed()
            ->where('code', 'like', $baseCode . '%')
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $latestDepartment ? intval(substr($latestDepartment->code, -3)) : 0;
        $newNumber = $lastNumber + 1;

        return $baseCode . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function parentDepartment()
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
    }

    public function subDepartments()
    {
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    public function headOfDepartment()
    {
        return $this->belongsTo(Employee::class, 'head_of_department_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function departmentKPIs()
    {
        return $this->hasMany(DepartmentKPI::class, 'department_id');
    }
}
