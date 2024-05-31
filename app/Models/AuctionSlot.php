<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_date',
        'auction_date_end',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'auction_slot_id', 'id');
    }
}
