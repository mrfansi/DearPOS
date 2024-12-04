<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DownPaymentConfig extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'minimum_percentage',
        'maximum_percentage',
        'default_percentage',
        'is_mandatory',
        'description'
    ];

    protected $casts = [
        'id' => 'string',
        'minimum_percentage' => 'decimal:2',
        'maximum_percentage' => 'decimal:2',
        'default_percentage' => 'decimal:2',
        'is_mandatory' => 'boolean'
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'down_payment_config_id');
    }
}
