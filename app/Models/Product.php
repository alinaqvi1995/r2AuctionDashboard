<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'description',
        'category_id',
        'subcategory_id',
        'manufacturer_id',
        'condition',
        'status',   // 1 active, 0   inactive,  2 sold
        'image',
        'auction_slot_id',
        'lot_no',
        'screens',
        'admin_approval',   // 0 waiting for approval ,1 approved, 2 not approved
        'reference',
        'listing_type',
        'material',
        'generation',
        'connectivity',
        'quantity',
        'auction_name',
        'lot_address',
        'lot_city',
        'lot_state',
        'lot_zip',
        'lot_country',
        'international_buyers',     // 1/0
        'shipping_requirements',
        'certificate_data_erasure',     // 1/0
        'certificate_hardware_destruction',     // 1/0
        'lot_sold_as_is',       // 1/0
        'notes',
        'bidding_close_time',
        'processing_time',
        'minimum_bid_price',
        'buy_now',      // 1/0
        'buy_now_price',
        'reserve_price',
        'model_size',
        'payment_requirement',
    ];
    
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id','id');
    }
    
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id','id');
    }

    // Define the relationship with Color
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'pivot_product_color', 'product_id', 'color_id');
    }

    // Define the relationship with Storage
    public function storages()
    {
        return $this->belongsToMany(Capacity::class, 'pivot_product_capacity', 'product_id', 'capacity_id');
    }
    
    // Define the relationship with Region
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'pivot_product_region', 'product_id', 'region_id');
    }

    // Define the relationship with ModelNumber
    public function modelNumbers()
    {
        return $this->belongsToMany(ModelNumber::class, 'pivot_product_model_number', 'product_id', 'model_number_id');
    }

    // Define the relationship with LockStatus
    public function lockStatuses()
    {
        return $this->belongsToMany(LockStatus::class, 'pivot_product_lock_status', 'product_id', 'lock_status_id');
    }

    // Define the relationship with Grade
    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'pivot_product_grade', 'product_id', 'grade_id');
    }

    // Define the relationship with Carrier
    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'pivot_product_carrier', 'product_id', 'carrier_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function auctionSlot()
    {
        return $this->belongsTo(AuctionSlot::class, 'auction_slot_id', 'id');
    }

    public function rams()
    {
        return $this->belongsToMany(Ram::class, 'pivot_product_ram', 'product_id', 'ram_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'pivot_product_size', 'product_id', 'size_id');
    }

    public function modelNames()
    {
        return $this->belongsToMany(ModelName::class, 'pivot_product_model_name', 'product_id', 'model_name_id');
    }

    public function wishlist()
    {
        return $this->hasMany(WishList::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
