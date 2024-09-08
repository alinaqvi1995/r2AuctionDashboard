<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'image',
        'title',
        'description',
        'rating',
        'status',
    ];
}