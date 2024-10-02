<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelName extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'category_id',
        'manufacturer_id',
        'index',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id','id');
    }
}
