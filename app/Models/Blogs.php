<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blogs extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','category_id','title', 'slug', 'image', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
