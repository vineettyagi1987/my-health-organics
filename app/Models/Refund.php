<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Refund extends Model
{
    protected $fillable = ['order_id','amount','reason','status','razorpay_refund_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

