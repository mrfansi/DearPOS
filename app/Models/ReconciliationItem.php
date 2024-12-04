<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ReconciliationItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'bank_statement_id',
        'transaction_id',
        'transaction_type',
        'bank_amount',
        'system_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'id' => 'string',
        'bank_amount' => 'decimal:4',
        'system_amount' => 'decimal:4'
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

    public function bankStatement()
    {
        return $this->belongsTo(BankStatement::class, 'bank_statement_id');
    }

    public function transaction()
    {
        return $this->morphTo('transaction');
    }
}
