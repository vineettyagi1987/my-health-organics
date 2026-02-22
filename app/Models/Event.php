<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','description','event_category_id',
        'event_date','price','meeting_link','status'
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class,'event_category_id');
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class,'event_faculty','event_id','faculty_id');
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }
}
