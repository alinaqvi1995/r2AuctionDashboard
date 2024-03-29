<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'title', 'type', 'description', 'status'];

    /**
     * Get the category that owns the variant.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('value', 'status')
            ->withTimestamps();
    }
}
