<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_cash',
        'is_card',
        'is_digital',
        'is_active'
    ];

    protected $casts = [
        'is_cash' => 'boolean',
        'is_card' => 'boolean',
        'is_digital' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
};
