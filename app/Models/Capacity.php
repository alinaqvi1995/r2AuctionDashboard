<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capacity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'brand_id', 'description', 'status'];

    protected $dates = ['deleted_at'];

    public function brand()
    {
        // return $this->belongsTo(Manufacturer::class);
        return $this->belongsTo(ModelName::class, 'brand_id');
    }

    // public function model()
    // {
    //     return $this->belongsTo(ModelName::class, 'brand_id');
    // }
}
