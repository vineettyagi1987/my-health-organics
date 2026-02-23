<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComingSoonItem extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'image',
        'launch_date',
        'location',
        'status'
    ];
}
