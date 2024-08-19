<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'brand_id', 'description', 'status', 'model_id'];

    public function brand()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function model()
    {
        return $this->belongsTo(ModelName::class, 'model_id');
    }
}
