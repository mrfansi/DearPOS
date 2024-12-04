<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ReturnRecord extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'returns';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'purchase_order_id',
        'sales_transaction_id',
        'supplier_id',
        'customer_id',
        'return_number',
        'return_date',
        'type',
        'status',
        'total_amount',
        'reason',
        'created_by'
    ];

    protected $casts = [
        'id' => 'string',
        'return_date' => 'date',
        'total_amount' => 'decimal:4'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Generate return number if not provided
            if (empty($model->return_number)) {
                $model->return_number = $model->generateReturnNumber();
            }
        });
    }

    public function generateReturnNumber()
    {
        $prefix = $this->type === 'purchase' ? 'PR' : 'SR';
        $latestReturn = self::where('type', $this->type)
            ->withTrashed()
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $latestReturn ? intval(substr($latestReturn->return_number, -6)) : 0;
        $newNumber = $lastNumber + 1;

        return $prefix . date('Ymd') . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function salesTransaction()
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
