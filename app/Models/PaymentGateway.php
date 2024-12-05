<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class PaymentGateway extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'credentials',
        'is_active',
    ];

    protected $casts = [
        'credentials' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'credentials',
    ];

    public function setCredentialsAttribute($value)
    {
        // Encrypt sensitive credentials before storing
        $this->attributes['credentials'] = $value 
            ? Crypt::encryptString(json_encode($value)) 
            : null;
    }

    public function getCredentialsAttribute($value)
    {
        // Decrypt credentials when retrieving
        return $value 
            ? json_decode(Crypt::decryptString($value), true) 
            : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function validateCredentials(): bool
    {
        // Placeholder method for credential validation
        // Implement specific validation logic for each payment gateway
        return $this->is_active && !empty($this->credentials);
    }
}
