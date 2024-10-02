<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'model_id', 'status'];

    public function model()
    {
        return $this->belongsTo(ModelName::class, 'model_id');
    }
}
