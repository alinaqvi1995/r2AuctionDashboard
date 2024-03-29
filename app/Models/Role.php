<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'status',
        'deleted_at',
    ];

   public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}