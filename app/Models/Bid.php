<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'bid_amount',
        'status',  // 0 = pending, 1 = accepted
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function getPendingBids()
    {
        return self::where('status', 0)->get();
    }

    public static function getAcceptedBids()
    {
        return self::where('status', 1)->get();
    }

    public static function getBidsByStatus($status)
    {
        return self::where('status', $status)->get();
    }
}
