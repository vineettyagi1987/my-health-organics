<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class WalletTransaction extends Model
{

protected $fillable=[
'user_id',
'amount',
'type',
'source',
'reference_id'
];

}