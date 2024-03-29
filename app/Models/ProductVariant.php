<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variant';

    protected $fillable = ['product_id', 'variant_id', 'value', 'status'];

    // Define any additional functionality or relationships here
}
