<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'subcategory_id',
        'manufacturer_id',
        'condition',
        'status',
        'image',
    ];
    
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id','id');
    }
    
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id','id');
    }

    // Define the relationship with Color
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'pivot_product_color', 'product_id', 'color_id');
    }

    // Define the relationship with Storage
    public function storages()
    {
        return $this->belongsToMany(Capacity::class, 'pivot_product_capacity', 'product_id', 'capacity_id');
    }
    
    // Define the relationship with Region
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'pivot_product_region', 'product_id', 'region_id');
    }

    // Define the relationship with ModelNumber
    public function modelNumbers()
    {
        return $this->belongsToMany(ModelNumber::class, 'pivot_product_model_number', 'product_id', 'model_number_id');
    }

    // Define the relationship with LockStatus
    public function lockStatuses()
    {
        return $this->belongsToMany(LockStatus::class, 'pivot_product_lock_status', 'product_id', 'lock_status_id');
    }

    // Define the relationship with Grade
    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'pivot_product_grade', 'product_id', 'grade_id');
    }

    // Define the relationship with Carrier
    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'pivot_product_carrier', 'product_id', 'carrier_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
