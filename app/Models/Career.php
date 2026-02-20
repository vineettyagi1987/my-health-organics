<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    //
    protected $fillable = [
    'objectives',
    'sapath_patra',
    'address',
    'city',
    'state',
    'phone',
    'email'
];
}
