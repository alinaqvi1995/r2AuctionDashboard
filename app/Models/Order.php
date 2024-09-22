<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'bid_id',
        'payment_method',
        'amount',
        'order_type',
        'payment_recipt',
        'payment_status',   // 0 = pending, 1 = paid
        'status',   // 0 = pending, 1 = shipped
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
