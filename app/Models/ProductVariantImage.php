<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Variant;

class ProductVariantImage extends Model
{

    protected $table = 'product_variant_images';

    protected $fillable = ['product_id', 'product_variant_id', 'image'];

    // Define relationships if applicable
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'product_variant_id');
    }
}
