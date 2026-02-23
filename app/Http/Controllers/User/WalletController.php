<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;

class WalletController extends Controller
{

public function index()
{

$user = auth()->user();

$wallet = $user->wallet;

$transactions = WalletTransaction::where('user_id',$user->id)
->latest()
->paginate(20);

return view('user.wallet.index',compact('wallet','transactions'));

}

}