<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductImage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'image_url',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get the product associated with the image
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with the image (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Upload and process an image for a product
     * 
     * @param \Illuminate\Http\UploadedFile $imageFile
     * @param Product $product
     * @param ProductVariant|null $variant
     * @return self
     */
    public static function uploadImage($imageFile, Product $product, ProductVariant $variant = null)
    {
        // Generate a unique filename
        $filename = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
        $path = "products/{$product->id}";

        // Create directory if it doesn't exist
        Storage::makeDirectory($path);

        // Process and save the image
        $processedImage = Image::make($imageFile)
            ->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 85);

        // Save the processed image
        Storage::put("{$path}/{$filename}", $processedImage);

        // Create thumbnail
        $thumbnailFilename = "thumb_{$filename}";
        $thumbnail = Image::make($imageFile)
            ->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);
        Storage::put("{$path}/{$thumbnailFilename}", $thumbnail);

        // Create database record
        return self::create([
            'product_id' => $product->id,
            'variant_id' => $variant ? $variant->id : null,
            'image_url' => "{$path}/{$filename}",
            'sort_order' => self::where('product_id', $product->id)->max('sort_order') + 1,
        ]);
    }

    /**
     * Get the full URL of the image
     */
    public function getImageUrlAttribute($value)
    {
        return Storage::url($value);
    }

    /**
     * Get the thumbnail URL of the image
     */
    public function getThumbnailUrlAttribute()
    {
        $path = $this->attributes['image_url'];
        $thumbnailPath = str_replace(
            basename($path), 
            'thumb_' . basename($path), 
            $path
        );
        return Storage::url($thumbnailPath);
    }
}
