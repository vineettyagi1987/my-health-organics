<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
'user_id','total_amount','payment_status','status'
];


public function items()
{
return $this->hasMany(OrderItem::class);
}
}
