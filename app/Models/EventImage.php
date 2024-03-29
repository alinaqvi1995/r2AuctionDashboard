<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventImage extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'image_url', 'image_name', 'status',
    ];

    /**
     * Get the event associated with the image.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}