<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;

class WithdrawController extends Controller
{

public function index()
{

    $user = auth()->user();

    $wallet = $user->wallet;

    $requests = WithdrawalRequest::where('user_id',$user->id)
    ->latest()
    ->get();

    return view('user.withdraw.index',compact('wallet','requests'));

}


public function requestWithdraw(Request $request)
{

$request->validate([
'amount'=>'required|numeric|min:100'
]);

$user = auth()->user();

if(!$user->bankAccount){

return back()->with('error','Please add bank account first');

}

if($request->amount > $user->wallet->balance){

return back()->with('error','Insufficient wallet balance');

}

WithdrawalRequest::create([
'user_id'=>$user->id,
'amount'=>$request->amount
]);

return back()->with('success','Withdrawal request submitted');

}

}