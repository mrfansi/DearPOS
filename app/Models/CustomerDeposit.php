<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CustomerDeposit extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'customer_id',
        'amount',
        'used_amount',
        'remaining_amount',
        'deposit_date',
        'expiry_date',
        'notes',
        'status'
    ];

    protected $casts = [
        'id' => 'string',
        'amount' => 'decimal:4',
        'used_amount' => 'decimal:4',
        'remaining_amount' => 'decimal:4',
        'deposit_date' => 'date',
        'expiry_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
            $model->remaining_amount = $model->amount;
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function transactions()
    {
        return $this->hasMany(DepositTransaction::class, 'customer_deposit_id');
    }
}
