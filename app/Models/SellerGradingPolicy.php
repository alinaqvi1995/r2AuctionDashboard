<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerGradingPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'grade',
        'description',
    ];
}
