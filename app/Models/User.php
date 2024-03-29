<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',

        'first_name',
        'last_name',
        'email',
        'role_id',
        'phone',
        'status',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'password',
        'deleted_at',
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
        // dd($this->role_id === "1");
        return $this->role->name === "Admin";
    }

    public function isVendor()
    {
        return $this->role->name === "Vendor";
    }

    public function isSubVendor()
    {
        return $this->role->name === "SubVendor";
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($permission)
    {
        // Check if the user has a role
        if (!$this->role) {
            return false;
        }

        // Check if the role has permissions
        if (!$this->role->permissions) {
            return false;
        }

        // Check if the role has the specified permission
        return $this->role->permissions->pluck('name')->contains($permission);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function subVendor()
    {
        return $this->hasOne(SubVendor::class);
    }
}
