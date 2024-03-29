<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['ticket_id', 'event_id', 'price', 'quantity', 'status'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the ticket associated with the event ticket.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the event associated with the event ticket.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
