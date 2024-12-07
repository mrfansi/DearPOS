<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAddress extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_current'
    ];

    protected $casts = [
        'is_current' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address_line_1;
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        $address .= ", {$this->city}, {$this->state} {$this->postal_code}, {$this->country}";
        return $address;
    }
}
