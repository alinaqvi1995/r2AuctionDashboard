<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'model_id', 'description', 'color_code', 'status'];

    public function model()
    {
        return $this->belongsTo(ModelName::class, 'model_id');
    }
}
