<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'model_id', 'description', 'color_code', 'status'];

    public function model()
    {
        return $this->belongsTo(ModelNumber::class, 'model_id');
    }
}
