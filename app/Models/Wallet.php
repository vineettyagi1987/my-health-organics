<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Wallet extends Model
{

protected $fillable=['user_id','balance'];

public function user()
{
return $this->belongsTo(User::class);
}

}

?>