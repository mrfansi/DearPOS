<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDocument extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'document_type',
        'document_number',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'issue_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'file_size' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getFullFilePathAttribute()
    {
        return storage_path('app/'.$this->file_path);
    }

    public function isExpired()
    {
        return $this->expiry_date && now()->gt($this->expiry_date);
    }
}
