<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'company_name',
        'email',
        'phone',
        'mobile',
        'website',
        'tax_number',
        'notes',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(SupplierProduct::class);
    }

    public function addresses()
    {
        return $this->hasMany(SupplierAddress::class);
    }

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
