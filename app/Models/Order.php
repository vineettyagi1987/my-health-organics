<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_number','subtotal','tax','shipping',
        'discount','total','status','payment_status',
        'payment_method','razorpay_order_id','razorpay_payment_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
    
public function user()
{
    return $this->belongsTo(User::class);
}
}

