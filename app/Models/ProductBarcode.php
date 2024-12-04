<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBarcode extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'barcode_type',
        'barcode_value',
    ];

    /**
     * Get the product associated with the barcode
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with the barcode (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Validate barcode based on its type
     */
    public function validateBarcode()
    {
        switch ($this->barcode_type) {
            case 'EAN13':
                return $this->validateEAN13();
            case 'UPC':
                return $this->validateUPC();
            case 'CODE128':
                return $this->validateCode128();
            default:
                return true; // Allow custom barcode types
        }
    }

    /**
     * Validate EAN13 barcode
     */
    private function validateEAN13()
    {
        $barcode = $this->barcode_value;
        if (!preg_match('/^[0-9]{13}$/', $barcode)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = intval($barcode[$i]);
            $sum += ($i % 2 == 0) ? $digit : $digit * 3;
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        
        return intval($barcode[12]) === $checkDigit;
    }

    /**
     * Validate UPC barcode
     */
    private function validateUPC()
    {
        $barcode = $this->barcode_value;
        if (!preg_match('/^[0-9]{12}$/', $barcode)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $digit = intval($barcode[$i]);
            $sum += ($i % 2 == 0) ? $digit * 3 : $digit;
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        
        return intval($barcode[11]) === $checkDigit;
    }

    /**
     * Validate Code 128 barcode (basic validation)
     */
    private function validateCode128()
    {
        // Basic validation for Code 128
        return preg_match('/^[0-9A-Za-z]+$/', $this->barcode_value) === 1;
    }
}
