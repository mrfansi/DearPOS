<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PaymentSchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'transaction_id',
        'sequence',
        'amount',
        'due_date',
        'status',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'id' => 'string',
        'amount' => 'decimal:4',
        'due_date' => 'date',
        'paid_at' => 'datetime'
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

    public function transaction()
    {
        return $this->belongsTo(SalesTransaction::class, 'transaction_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'payment_schedule_id');
    }
}
