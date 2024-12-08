<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseAudit extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_audits';

    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'event',
        'old_values',
        'new_values',
        'user_id',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auditable()
    {
        return $this->morphTo();
    }
}
