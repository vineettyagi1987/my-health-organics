<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSale extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'quantity',
        'amount',
        'sale_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
