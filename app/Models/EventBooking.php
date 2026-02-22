<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    protected $fillable = [
        'user_id','event_id','amount','payment_id','status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
