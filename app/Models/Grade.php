<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'status', 'carrier_id'];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }
}
