<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'brand_id', 'description', 'status'];

    public function brand()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
