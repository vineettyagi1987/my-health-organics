<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
  

    protected $fillable = [
        'name',
        'designation',
        'qualifications',
        'email',
        'image',
        'bio'
    ];

    public function events()
    {
      return $this->belongsToMany(Event::class,'event_faculty','faculty_id','event_id');
    }
}
