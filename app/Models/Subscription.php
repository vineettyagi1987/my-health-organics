<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
class Subscription extends Model
{
    protected $fillable = [
        'user_id','product_id','razorpay_subscription_id',
        'status','start_date','end_date'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
