<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'account_holder',
        'account_number',
        'ifsc',
        'bank_name',
        'razorpay_fund_account_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}