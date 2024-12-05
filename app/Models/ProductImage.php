<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'file_name',
        'file_path',
        'mime_type',
        'size',
        'is_primary',
        'display_order'
    ];

    protected $casts = [
        'size' => 'integer',
        'is_primary' => 'boolean',
        'display_order' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrl(): string
    {
        return asset($this->file_path);
    }

    public function resize(int $width, int $height): bool
    {
        // TODO: Implement image resize logic
        return true;
    }

    public function optimize(): bool
    {
        // TODO: Implement image optimization logic
        return true;
    }
}
