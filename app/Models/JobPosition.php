<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosition extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'department_id',
        'title',
        'code',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
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
