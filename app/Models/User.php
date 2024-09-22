<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'middle_name',
        'last_name',
        'full_name',
        'phone',
        'state',
        'city',
        'address',
        'business_name',
        'business_email',
        'designation',
        'business_website',
        'business_desc',
        'password',
        'role',
        'status',
        'avatar',
        'admin_approval',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function getUserTypeAttribute()
    {
        if ($this->buyer) {
            return $this->buyer->user_type;
        }

        if ($this->seller) {
            return $this->seller->user_type;
        }

        return '-';
    }

    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function wishlist()
    {
        return $this->hasMany(WishList::class);
    }
}
