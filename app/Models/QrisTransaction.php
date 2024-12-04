<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QrisTransaction extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'payment_id',
        'qris_reference_number',
        'merchant_id',
        'terminal_id',
        'amount',
        'status',
        'transaction_time',
        'response_payload'
    ];

    protected $casts = [
        'id' => 'string',
        'amount' => 'decimal:4',
        'transaction_time' => 'datetime',
        'response_payload' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
